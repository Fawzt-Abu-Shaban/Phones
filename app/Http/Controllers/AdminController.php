<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins = Admin::where('id', '!=', auth('admin')->id())->get();
        return response()->view('cms.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $role = Role::where('guard_name', 'admin')->get();
        return response()->view('cms.admins.create', compact('role'));
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
            'role_id' => 'required|integer|exists:roles,id',
            'name' => 'required|string|min:4|max:100',
            'email' => 'required|email|string|unique:admins,email',
        ]);
        if (!$validator->fails()) {
            $role = Role::findById($request->get('role_id'), 'admin');
            $admin = new Admin();
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->password = Hash::make(12345);
            $isSaved = $admin->save();

            
            if ($isSaved) {
                event(new Registered($admin));
                $admin->assignRole($role);
            }
            return response()->json([
                'message' => $isSaved ? 'Admin Created Successfully' : 'Failed To Create Admin'
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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Admin $admin)
    {
        //
        $assignedRole = $admin->getRoleNames()[0];
        $role = Role::where('guard_name', 'admin')->get();
        return response()->view('cms.admins.edit', compact('admin', 'role', 'assignedRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $validator = Validator($request->all(), [
            'role_id' => 'required|integer|exists:roles,id',
            'name' => 'required|string|min:4|max:100',
            'email' => 'required|email|string|unique:admins,email,' . $admin->id,
        ]);
        if (!$validator->fails()) {
            $role = Role::findById($request->get('role_id'), 'admin');
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->syncRoles($role);
            }
            return response()->json([
                'message' => $isSaved ? 'Admin Updated Successfully' : 'Failed To Updated Admin'
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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $isDeleted = $admin->delete();
        return response()->json([
            'title' => $isDeleted ? 'Deleted Successfully' : 'Deleted Failed',
            'icon' => $isDeleted ? 'success' : 'danger',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
