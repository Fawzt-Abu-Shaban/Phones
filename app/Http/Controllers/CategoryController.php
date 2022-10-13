<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::withCount('type')->paginate(10);
        if (auth('api')->check()) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $category,
            ]);
        }
        return response()->view('cms.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.category.create');
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
            'name_en' => 'required|string|min:4|max:20',
            'name_ar' => 'nullable|string|min:4|max:20',
            'is_visible' => 'in:on|string',
        ], [
            'name.required' => 'please, Enter Category Name'
        ]);

        $category = new Category();
        $category->name_en = $request->get('name_en');
        $category->name_ar = $request->get('name_ar');
        $category->is_visible = $request->has('is_visible');
        $is_Saved = $category->save();
        if ($is_Saved) {
            session()->flash('msg', 'Category Created Successfuly');
            return redirect()->route('category.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('cms.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            'name_en' => 'required|string|min:4|max:20',
            'name_ar' => 'nullable|string|min:4|max:20',
            'is_visible' => 'in:on|string',
        ], [
            'name.required' => 'please, Enter Category Name'
        ]);


        $category->name_en = $request->get('name_en');
        $category->name_ar = $request->get('name_ar');
        $category->is_visible = $request->has('is_visible');
        $is_Saved = $category->save();
        if ($is_Saved) {
            // session()->flash('type' , 'success');
            session()->flash('msg', 'Category Updated Successfuly');
            return redirect()->route('category.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $deleted = $category->delete();
        if ($deleted) {
            return response()->json(['title' => 'Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Delete Failed', 'icon' => 'danger']);
        }
    }
}
