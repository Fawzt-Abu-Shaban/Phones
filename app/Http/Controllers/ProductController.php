<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Dotenv\Validator;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
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
        // $product = Product::with('type')->get();
        $product = Product::with('type')->withTrashed()->latest()->paginate(6);

        return response()->view('cms.product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $type = Type::where('is_visible', true)->get();
        // $type = Type::all();
        return response()->view('cms.product.create', compact('type'));
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
        $request->validate([
            'name_en' => 'required|string|min:4|max:100',
            'name_ar' => 'nullable|string|min:4|max:100',
            'info' => 'nullable|string|min:5|max:150',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|in:Black,White,Gray,NavyBlue,Pink,Orange',
            'image' => 'required|image|mimes:jpg,png|max:2048',
            'album' => 'required',
            'discount' => 'nullable|integer',
            'old_price' => 'nullable|integer',
            'type_id' => 'required|integer|exists:types,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . 'mobile' . '.' . $image->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('products', $imageName, ['disk' => 'public']);
        }

        $album_name = [];
        if ($request->hasfile('album')) {
            foreach ($request->file('album') as $album) {
                $albumName = time() . '_' . 'mobile' . '.' . $album->getClientOriginalExtension();
                $album_name[] = $albumName;
                $album->storePubliclyAs('albums', $albumName, ['disk' => 'public']);
            }
            $album_name = implode(',', $album_name);
        }

        $product = new Product;
        $product->name_en = $request->name_en;
        $product->name_ar = $request->name_ar;
        $product->info = $request->info;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->color = $request->color;
        $product->image = $imageName;
        $product->album = $album_name;
        $product->discount = $request->discount;
        $product->old_price = $request->old_price;
        $product->user_id = Auth::user()->id;
        $product->type_id = $request->type_id;

        $isSaved = $product->save();

        if ($isSaved) {
            session()->flash('msg', 'Product Created Successfuly');
            return back()->with('type', 'success');
        } else {
            session()->flash('msg', 'Failed To Add Product ');
            return back()->with('type', 'danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $type = Type::where('is_visible', true)->get();
        return response()->view('cms.product.edit', compact('type', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator = Validator($request->all(), [
            'name_en' => 'required|string|min:4|max:100',
            'name_ar' => 'nullable|string|min:4|max:100',
            'info' => 'nullable|string|min:5|max:150',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|string|in:Black,White,Gray,NavyBlue,Pink,Orange',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'album' => 'nullable',
            'discount' => 'nullable|integer',
            'old_price' => 'nullable|integer',
            'type_id' => 'required|integer|exists:types,id',
        ]);

        // $product->findOrFail($id);

        $imageName = $product->image;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('products/', $product->image);
            $image = $request->file('image');
            $imageName = time() . '_' . 'mobile' . '.' . $image->getClientOriginalExtension();
            $request->file('image')->storePubliclyAs('products', $imageName, ['disk' => 'public']);
        }

        $album_name = $product->album;


        if ($request->hasfile('album')) {
            $album_name = [];
            Storage::disk('public')->delete('products/', $product->album);
            foreach ($request->file('album') as $album) {
                $albumName = time() . '_' . 'mobile' . '.' . $album->getClientOriginalExtension();
                $album_name[] = $albumName;
                $album->storePubliclyAs('albums', $albumName, ['disk' => 'public']);
            }
            $album_name = implode(',', $album_name);
        }


        $product->name_en = $request->name_en;
        $product->name_ar = $request->name_ar;
        $product->info = $request->info;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->color = $request->color;
        $product->image = $imageName;
        $product->album = $album_name;
        $product->discount = $request->discount;
        $product->old_price = $request->old_price;
        $product->user_id = Auth::user()->id;
        $product->type_id = $request->type_id;

        $isSaved = $product->save();

        if ($isSaved) {
            session()->flash('msg', 'Product Updated Successfuly');
            // return redirect()->route('product.index')->with('type', 'success');
            return response()->json([
                'message' => 'Type Updated Successfully'
            ], Response::HTTP_OK);
        } else {
            session()->flash('msg', 'Failed To Update Product ');
            // return back()->with('type', 'danger');
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->trashed()) {
            $status = $product->restore();
        } else {
            $status = $product->delete();
        }

        return response()->json(
            [
                'title' => $status ? 'Restore Successfully' : 'Deleted Successfully',
                'icon' => $status ? 'success' : 'warning'
            ],
            Response::HTTP_OK
        );
    }
}
