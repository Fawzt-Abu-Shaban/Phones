<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class permissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permission = Permission::all();
        return response()->view('cms.permission.index', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.permission.create');
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
            'name' => 'required|string|min:4|max:40',
            'guard' => 'required|string|in:admin,user',
        ]);

        if (!$validator->fails()) {
            $permission = new Permission();
            $permission->name = $request->get('name');
            $permission->guard_name = $request->get('guard');
            $isSaved = $permission->save();
            return response()->json([
                'message' => $isSaved ? 'Permission Created Successfully' : 'Failed To Create Permission'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
        return response()->view('cms.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:4|max:40',
            'guard' => 'required|string|in:admin,user',
        ]);

        if (!$validator->fails()) {
            $permission->name = $request->get('name');
            $permission->guard_name = $request->get('guard');
            $isSaved = $permission->save();
            return response()->json([
                'message' => $isSaved ? 'Permission Updated Successfully' : 'Failed To Update Permission'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
        $isDeleted = $permission->delete();
        return response()->json([
            'title' => $isDeleted ? 'Deleted Successfully' : 'Deleted Failed',
            'icon' => $isDeleted ? 'success' : 'danger',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
