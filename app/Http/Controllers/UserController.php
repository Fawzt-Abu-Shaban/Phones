<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeEmail;
use App\Notifications\orderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::withCount('permissions')->get();
        return response()->view('cms.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.users.create');
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
            'name' => 'required|string|min:4|max:100',
            'address' => 'required|string|min:6|max:100',
            'phone' => 'required|numeric',
            'email' => 'required|email|string|unique:users,email',
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->get('name');
            $user->address = $request->get('address');
            $user->phone = $request->get('phone');
            $user->email = $request->get('email');
            $user->password = Hash::make(123456);
            $isSaved = $user->save();
            if ($isSaved) {
                event(new Registered($user));
                // $user->notify(new orderNotification);
                // Mail::to($user->email)->send(new WelcomeEmail());
            }




            return response()->json([
                'message' => $isSaved ? 'User Created Successfully' : 'Failed To Create User'
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return response()->view('cms.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:4|max:100',
            'address' => 'required|string|min:6|max:100',
            'phone' => 'required|numeric',
            'email' => 'required|email|string|unique:users,email,' . $user->id,
        ]);
        if (!$validator->fails()) {
            $user->name = $request->get('name');
            $user->address = $request->get('address');
            $user->phone = $request->get('phone');
            $user->email = $request->get('email');
            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'User Created Successfully' : 'Failed To Create User'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $isDeleted = $user->delete();
        return response()->json([
            'title' => $isDeleted ? 'Deleted Successfully' : 'Deleted Failed',
            'icon' => $isDeleted ? 'success' : 'danger',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
