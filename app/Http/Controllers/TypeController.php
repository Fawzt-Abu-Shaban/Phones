<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $types = Type::withCount('product')->get();
        $type = Type::withCount(['category', 'product'])->get();
        if (auth('api')->check()) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $type,
            ]);
        }
        return response()->view('cms.type.index', compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = Category::where('is_visible', true)->get();
        return response()->view('cms.type.create', compact('category'));
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
            'name_en' => 'required|string|min:4|max:45',
            'name_ar' => 'nullable|string|min:4|max:20',
            'is_visible' => 'required|boolean',
            'bio' => 'nullable|min:5|max:90',
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        if (!$validator->fails()) {
            //TODO: SUCCESS -> CREATE TYPE
            $type = new Type();
            $type->name_en = $request->get('name_en');
            $type->name_ar = $request->get('name_ar');
            $type->bio = $request->get('bio');
            $type->category_id = $request->get('category_id');
            $type->is_visible = $request->get('is_visible');
            $isSaved = $type->save();
            return response()->json([
                'message' => $isSaved ? 'Type Created Successfully' : 'Failed To Create Type'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            //TODO: FAILED -> VALIDATION ERROR
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
        $category = Category::where('is_visible', true)->get();
        return response()->view('cms.type.edit', compact('type', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //
        $validator = Validator($request->all(), [
            'name_en' => 'required|string|min:4|max:45',
            'name_ar' => 'nullable|string|min:4|max:20',
            'bio' => 'nullable|min:5|max:90',
            'is_visible' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        if (!$validator->fails()) {
            $type->name_en = $request->get('name_en');
            $type->name_ar = $request->get('name_ar');
            $type->bio = $request->get('bio');
            $type->is_visible = $request->get('is_visible');
            $type->category_id = $request->get('category_id');
            $isSaved = $type->save();
            return response()->json([
                'message' => $isSaved ? 'Type Updated Successfully' : 'Failed To Update Type'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            //TODO: FAILED -> VALIDATION ERROR
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        //
        $is_deleted = $type->delete();
        return response()->json([
            'title' => $is_deleted ? 'Deleted Successfully' : 'Deleting Failed',
            'icon' => $is_deleted ? 'success' : 'danger'
        ], $is_deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
