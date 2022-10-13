<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotification;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::with('user')->get();

        return response()->view('cms.order.index', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        // $validator = Validator($request->all(), [
        //     'name' => 'required|string|min:4|max:100',
        //     'address' => 'required|string|min:6|max:20',
        //     'phone' => 'required|min:10|max:25',
        //     'payment_type' => 'required|string|in:FromStore,Delivery',
        //     'status' => 'required|string|in:Waiting,Processing,Delivered,Combleted,Canceled',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => $validator->getMessageBag()->first()
        //     ], Response::HTTP_BAD_REQUEST);
        // } else {

        //     $total = 0;
        //     $item = '';
        //     if (auth('user')->check()) {
        //         foreach (Auth::user('id')->cart()->whereNull('order_id')->get() as $cart) {
        //             $total += $cart->product->price;
        //             $item = $cart->product->name_en;
        //         }
        //     } else {
        //         $total = 0;
        //     }

        //     $order = new Order();
        //     $order->name = $request->get('name');
        //     $order->address = $request->get('address');
        //     $order->phone = $request->get('phone');
        //     $order->item = $item;
        //     $order->total = $total;
        //     $order->invoice_number = rand(000000, 999999);
        //     $order->payment_type = $request->get('payment_type');
        //     $order->status = $request->get('status');
        //     $order->user_id = Auth::auth('user')->id();

        //     $isSaved = $order->save();
        //     // session()->flash('msg', $isSaved ? 'order Updated Successfully' : 'Failed To Updated order');
        //     return response()->json([
        //         'message' => $isSaved ? 'order Updated Successfully' : 'Failed To Updated order'
        //     ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        $ORDuser = Order::with('user')->get();
        return response()->view('cms.order.invoice', compact('order', 'ORDuser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
        return response()->view('cms.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:4|max:100',
            'address' => 'required|string|min:6|max:100',
            'phone' => 'required|numeric',
            'payment_type' => 'required|string|in:FromStore,Delivery',
            'status' => 'required|string|in:Waiting,Processing,Delivered,Combleted,Canceled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        } else {

            $order->name = $request->get('name');
            $order->address = $request->get('address');
            $order->phone = $request->get('phone');
            $order->payment_type = $request->get('payment_type');
            $order->status = $request->get('status');
            $order->user_id = Auth::user()->id;

            $isSaved = $order->save();

            // session()->flash('msg', $isSaved ? 'order Updated Successfully' : 'Failed To Updated order');
            return response()->json([
                'message' => $isSaved ? 'order Updated Successfully' : 'Failed To Updated order'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
