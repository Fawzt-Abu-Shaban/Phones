<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $slider = Slider::withTrashed()->latest()->paginate(3);
        if (auth('api')->check()) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $slider,
            ]);
        } else {
            return response()->view('cms.slider.index', compact('slider'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.slider.create');
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
            'price' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpg,png|max:2048',
        ]);
        if (!$validator->fails()) {
            $slider = new Slider();
            $slider->name_en = $request->get('name_en');
            $slider->name_ar = $request->get('name_ar');
            $slider->price = $request->get('price');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $slider->name_en . '.' . $image->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('sliders', $imageName, ['disk' => 'public']);
                $slider->image = $imageName;
            }

            $isSaved = $slider->save();
            return response()->json(
                [
                    'message' => $isSaved ? 'Slider Created Successfully' : 'Failed To Create Slider'
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
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
        return response()->view('cms.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
        $validator = Validator($request->all(), [
            'name_en' => 'required|string|min:4|max:100',
            'name_ar' => 'nullable|string|min:4|max:20',
            'price' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);
        if (!$validator->fails()) {
            $slider->name_en = $request->get('name_en');
            $slider->name_ar = $request->get('name_ar');
            $slider->price = $request->get('price');

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete("/sliders/$slider->image");
                $image = $request->file('image');
                $imageName = time() . '_' . $slider->name_en . '.' . $image->getClientOriginalExtension();
                $request->file('image')->storePubliclyAs('sliders', $imageName, ['disk' => 'public']);
                $slider->image = $imageName;
            }

            $isSaved = $slider->save();
            return response()->json(
                [
                    'message' => $isSaved ? 'Slider Created Successfully' : 'Failed To Create Slider'
                ],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $slider = Slider::withTrashed()->findOrFail($id);
        if ($slider->trashed()) {
            $status = $slider->restore();
        } else {
            $status = $slider->delete();
        }

        return response()->json(
            [
                'title' => $status ? 'Restore Successfully' : 'Deleted Successfully',
                'icon' => $status ? 'success' : 'warning'
            ],
            Response::HTTP_OK
        );

        // $is_deleted = $slider->delete();
        // return response()->json([
        //     'title' => $is_deleted ? 'Deleted Successfully' : 'Deleting Failed',
        //     'icon' => $is_deleted ? 'success' : 'danger'
        // ], $is_deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
