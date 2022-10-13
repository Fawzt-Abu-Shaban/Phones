<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product = Product::latest()->simplePaginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $product,
        ]);
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
        $validator = Validator($request->all(), [
            'name_en' => 'required|string|min:4|max:100',
            'name_ar' => 'nullable|string|min:4|max:20',
            'info' => 'required|string|min:5|max:150',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|in:Black,White,Gray,NavyBlue,Pink,Orange',
            'image' => 'required|image|mimes:jpg,png|max:2048',
            'album' => 'required|mimes:jpg,png',
            'discount' => 'nullable|integer',
            'old_price' => 'nullable|integer',
            'type_id' => 'required|integer|exists:types,id',
        ]);
        if (!$validator->fails()) {
            $product = new Product();
            $product->user_id = Auth::user()->id;
            $product->name_en = $request->get('name_en');
            $product->name_ar = $request->get('name_ar');
            $product->info = $request->get('info');
            $product->price = $request->get('price');
            $product->quantity = $request->get('quantity');
            $product->color = $request->get('color');
            $product->discount = $request->get('discount');
            $product->old_price = $request->get('old_price');
            $product->type_id = $request->get('type_id');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $product->name . '.' . $image->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('products', $imageName, ['disk' => 'public']);
                $product->image = $imageName;
            }

            $album_path = [];
            if ($request->hasFile('album')) {
                $albums = $request->file('album');
                foreach ($albums as $album) {
                    $albumName = time() . '_' . $product->name_en . '.' . $album->getClientOriginalExtension();
                    $album_path[] = $albumName;
                    $album->storePubliclyAs('albums', $albumName, ['disk' => 'public']);
                }
                $album_ = implode(',', $album_path);
                $product->album = $album_;
            }

            $isSaved = $product->save();
            return response()->json(
                [
                    'message' => $isSaved ? 'Product Created Successfully' : 'Failed To Create Product'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Product::findOrFail($id);
        return response()->json([
            'status' => $product ? true : false,
            'message' => $product ? 'Success' : 'Failed',
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator = Validator($request->all(), [
            'name_en' => 'required|string|min:4|max:100',
            'name_ar' => 'nullable|string|min:4|max:20',
            'info' => 'required|string|min:5|max:150',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|in:Black,White,Gray,NavyBlue,Pink,Orange',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'album' => 'nullable|mimes:jpg,png|max:2048',
            'discount' => 'nullable|integer',
            'old_price' => 'nullable|integer',
            'type_id' => 'required|integer|exists:types,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        } else {
            $product->user_id = Auth::user()->id;
            $product->name_en = $request->get('name_en');
            $product->name_ar = $request->get('name_ar');
            $product->info = $request->get('info');
            $product->price = $request->get('price');
            $product->quantity = $request->get('quantity');
            $product->color = $request->get('color');
            $product->discount = $request->get('discount');
            $product->old_price = $request->get('old_price');
            $product->type_id = $request->get('type_id');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete("/products/$product->image");
                $image = $request->file('image');
                $imageName = time() . '_' . $product->name . '.' . $image->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('products', $imageName, ['disk' => 'public']);
                $product->image = $imageName;
            }

            if ($request->hasFile('album')) {
                foreach ($request->file('album') as $album) {
                    Storage::disk('public')->delete("/albums/$product->album");
                    $albumName = time() . '_' . $product->name_en . '.' . $album->getClientOriginalExtension();
                    $album_name[] = $albumName;
                    $album->storePubliclyAs('albums', $albumName, ['disk' => 'public']);
                }
                $album_ = implode(',', $album_name);
                $product->album = $album_;
            }

            $isSaved = $product->save();
            // session()->flash('msg', $isSaved ? 'Product Updated Successfully' : 'Failed To Updated Product');
            return response()->json([
                'message' => $isSaved ? 'Product Updated Successfully' : 'Failed To Updated Product'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$deleted = Product::destroy($id)
        $deleted = Product::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => $deleted ? 'Deleted Successfully' : 'Deleted Failed',
            'data' => $deleted,
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
