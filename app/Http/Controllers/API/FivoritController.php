<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Favorit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Notifications\OrderNotification;
use App\Listeners\SendNewOrderNotification;
use Symfony\Component\HttpFoundation\Response;

class FivoritController extends Controller
{
    //
    public function favoriteProduct($id, Favorit $favorite)
    {
        if (
            auth('api')->user()->favorite()->where('product_id', $id)->exists()
        ) {

            // $isDeleted = $favorite->findOrFail($favorite->id)->delete();

            $isDeleted = Favorit::where('user_id', Auth::user()->id)
                ->where('product_id', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Remove Successfully',
                'data' => $isDeleted ? 'Done' : 'Error',
            ], Response::HTTP_OK);
        } else {
            $favorite->product_id = $id;
            $favorite->user_id = Auth::user()->id;
            $isSaved = $favorite->save();
            return response()->json([
                'status' => true,
                'message' => 'Add Successfully',
                'data' => $isSaved ? 'Success' : 'Error',
            ], Response::HTTP_CREATED);
        };
    }

    public function showFavorite()
    {
        $favorite = Favorit::latest()->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $favorite,
        ]);
    }

    public function showCart()
    {
        $cart = Cart::latest()->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $cart,
        ]);
    }

    public function increaseQuantity($id)
    {
        if ($cart = Cart::where('Product_id', $id)->first()) {
            $cart->increment('qty', 1);
        }
    }

    public function decreaseQuantity(Request $request)
    {
        if ($cart = Cart::where('Product_id', $request->id)->first()) {
            $cart->decrement('qty', 1);
        }
    }

    public function cartProduct($id, Cart $cart, Request $request)
    {
        if (auth('api')->user()->cart()->where('product_id', $id)->exists()) {

            $isDeleted = Cart::where('user_id', Auth::user()->id)
                ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Remove Successfully',
                'data' => $isDeleted ? 'Done' : 'Error',
            ], Response::HTTP_OK);
            // }
        } else {
            $cart->product_id = $id;
            $cart->user_id = Auth::user()->id;
            $cart->qty = 1;

            $isSaved = $cart->save();
            return response()->json([
                'status' => true,
                'message' => 'Add Successfully',
                'data' => $isSaved ? 'Success' : 'Error',
            ], Response::HTTP_CREATED);
        };
    }


    public function checkout(Request $request, Order $order)
    {
        //
        $cart = Cart::with('product')->where('user_id', Auth::user()->id)->get();
        $products = Product::select('id', 'quantity')->whereIn('id', $cart->pluck('product_id'))
            ->pluck('quantity', 'id');

        foreach ($cart as $carts) {
            if (
                !isset($products[$carts->product_id])
                || $products[$carts->product_id] < $carts->qty
            ) {
                return response()->json([
                    'message' => 'Error: Product ' .
                        $carts->product->name_en .
                        ' Does not have Enough Quantity',
                ]);
            }
        }

        try {
            DB::transaction(function () use ($cart, $request, $order) {

                $validator = Validator($request->all(), [
                    'name' => 'required|string|min:4|max:100',
                    'address' => 'required|string|min:6|max:100',
                    'phone' => 'required|numeric',
                    'payment_type' => 'required|string|in:FromStore,Delivery',
                ]);

                $item = [];
                foreach ($cart as $carts) {
                    $item[] = $carts->product->name_en;
                    $items = implode(',', $item);
                }


                if (!$validator->fails()) {
                    $order->name = $request->get('name');
                    $order->address = $request->get('address');
                    $order->phone = $request->get('phone');

                    $order->item = $items;

                    $order->total = 0;
                    $order->invoice_number = rand(000000, 999999);
                    $order->payment_type = $request->get('payment_type');
                    $order->user_id = Auth::user()->id;
                    $isSaved = $order->save();
                    // if ($isSaved) {
                    //     event(new SendNewOrderNotification($order));
                    // }
                } else {
                    return response()->json([
                        'message' => $validator->getMessageBag()->first()
                    ], Response::HTTP_BAD_REQUEST);
                }

                foreach ($cart as $carts) {
                    $order->products()->attach(
                        $carts->product_id,
                        [
                            // 'order_id' => $carts->id,
                            'quantty' => $carts->qty,
                            'price' => $carts->product->price,
                        ]
                    );

                    $order->increment('total', $carts->qty * $carts->product->price);

                    Product::find($carts->product_id)->decrement('quantity', $carts->qty);
                }

                Cart::where('user_id', Auth::user()->id)->delete();

                // if ($isSaved) {
                //     // $user = User::first();
                //     event(new Order(Auth::user()->id));
                // }

                return response()->json([
                    'message' => $isSaved ? 'Your request has been successfully fulfilled' : 'Your request was not successfully executed'
                ]);
            });
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Error Happened. Try Again or Contact Us.',
            ]);
        }
    }
}
