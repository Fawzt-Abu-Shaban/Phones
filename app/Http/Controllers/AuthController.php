<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function showLogin(Request $request,)
    {
        return response()->view('cms.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string|min:4|max:15',
            'remember' => 'required|boolean',
        ]);
        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];
        if (!$validator->fails()) {
            if (Auth::guard('user')->attempt($credentials, $request->get('remember')) || Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
                return response()->json([
                    'message' => 'Logged in Successfully',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Error Credential , Please Try Again'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function showRegister(Request $requset)
    {
        return response()->view('cms.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:4|max:100',
            'address' => 'required|string|min:6|max:100',
            'phone' => 'required|numeric|min:10|max:25',
            'email' => 'required|email|string|unique:users,email',
            'new_password' => 'required|string|min:4|max:15|confirmed',
            'agreeTerms' => 'required|boolean:1',
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->get('name');
            $user->address = $request->get('address');
            $user->phone = $request->get('phone');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('new_password'));

            if ($request->get('agreeTerms') == true) {
                $isSaved = $user->save();
            } else {
                return response()->json([
                    'message' => 'You Must Click in AgreeTerms',
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($isSaved) {
                event(new Registered($user));
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

    public function showChangePassword(Request $request)
    {
        return response()->view('cms.auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $guardpas = auth('admin')->check() ? 'current_password:admin' : 'current_password:user',
            'current_password' => 'required|' . $guardpas,
            'new_password' => 'required|string|min:4|max:15|confirmed',
        ]);
        if (!$validator->fails()) {
            $guard = auth('admin')->check() ? 'admin' : 'user';
            $user = auth($guard)->user();
            $user->password = Hash::make($request->get('new_password'));
            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'Password Change Successfully' : 'Failed To Change Password'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator(
            $request->all(),
            ['email' => 'required|email']
        );

        if (!$validator->fails()) {

            $status = Password::sendResetLink(
                $request->only('email')
            );
            return $status ? response()->json([
                'status' => __($status),
                'message' => 'A fresh verification link has been sent to your email address.    '
            ]) :  response()->json([
                'email' => __($status),
                'message' => 'Wrong Email'
            ]);
        } else {

            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function resetPassword(Request $request)
    {
        $validate = Validator($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        if (!$validate->fails()) {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );
            return $status = Password::PASSWORD_RESET
                ? response()->json([
                    'status' => __($status),
                    'message' => 'Success'
                ]) :  response()->json([
                    'email' => [__($status)],
                    'message' => 'Error'
                ]);
        } else {
            return response()->json(
                [
                    'message' => $validate->getMessageBag()->first(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function logout(Request $request)
    {
        $guard = auth('admin')->check() ? 'admin' : 'user';
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        return redirect()->route('mobile.login', $guard);
    }
}
