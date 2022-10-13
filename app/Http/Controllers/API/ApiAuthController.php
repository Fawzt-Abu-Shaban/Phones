<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{

    // public function login(Request $request)
    // {
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|email|string|exists:users,email',
    //         'password' => 'required|string',
    //     ]);

    //     if (!$validator->fails()) {
    //         $user = User::where('email', $request->get('email'))->first();
    //         if (Hash::check($request->get('password'), $user->password)) {
    //             //to logout from ather devises
    //             $this->revokActiveTokens($user->id);
    //             //to not login from two devises
    //             if (!$this->activeLogin($user->id)) {
    //                 $token = $user->createToken('User-Token');
    //                 $user->setAttribute('token', $token->accessToken);
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => 'Logged in Successfully',
    //                     'data' => $user,
    //                     // 'token' => $token,
    //                 ]);
    //             } else {
    //                 return response()->json([
    //                     'status' => false,
    //                     'message' => 'Unable to login from two devices at the same time',
    //                 ]);
    //             }
    //         } else {
    //             return response()->json(['message' => 'Login Failed, Wrong Credentials'], Response::HTTP_BAD_REQUEST);
    //         }
    //     } else {
    //         return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|string|exists:users,email',
            // 'name' => 'required|string|exists:users,name',
            'password' => 'required|string',
        ]);

        if (!$validator->fails()) {
            return $this->generatePasswordGrantToken($request);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function generatePasswordGrantToken(Request $request)
    {
        try {
            $response = Http::asForm()->post(
                'http://127.0.0.1:8001/oauth/token',
                [
                    'grant_type' => 'password',
                    'client_id' => '1',
                    'client_secret' => 'qVhaaMCDhMWdQslyC3uazWLrx8MbZATEjC691Qmz',
                    'username' => $request->get('email'),
                    // 'username' => $request->get('name'),
                    'password' => $request->get('password'),
                    'scope' => '*'
                ]
            );

            $user = User::where('email', $request->get('email'))->first();
            // $user = User::where('name', $request->get('name'))->first();

            $user->setAttribute('token', $response->json()['access_token']);
            $user->setAttribute('token_type', $response->json()['token_type']);

            return response()->json([
                'status' => true,
                'message' => 'Logged in Successfully',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            $message = '';
            if ($response['error'] == 'invalid_grant') {
                $message = 'Login Failed , wrong Credentials';
            } else {
                $message = 'Somthing Went Wrong, please try again!';
            }
            return response()->json([
                'status' => false,
                'message' => $message,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // public function activeLogin($user_id)
    // {
    //     return DB::table('oauth_access_tokens')
    //         ->where('user_id', $user_id)
    //         ->where('name', 'User-Token')
    //         ->where('revoked', false)
    //         ->count();
    // }

    // public function revokActiveTokens($user_id)
    // {
    //     DB::table('oauth_access_tokens')
    //         ->where('user_id', $user_id)
    //         ->where('name', 'User-Token')
    //         ->where('revoked', false)
    //         ->update(['revoked' => true]);
    // }

    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:4|max:100',
            'address' => 'required|string|min:6|max:100',
            'phone' => 'required|integer',
            'email' => 'required|email|string|unique:users,email',
            'new_password' => 'required|string|min:4|max:15|confirmed',
            'agreeTerms' => 'required|boolean:1',
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $token = $user->createToken('User-Token');
            $user->setAttribute('token', $token->accessToken);
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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password:user',
            'new_password' => 'required|string|min:4|max:15|confirmed',
        ]);
        if (!$validator->fails()) {
            $guard = auth('user')->check();
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


    public function logout(Request $request)
    {
        $token = auth('api')->user()->token();
        $revoked = $token->revoke();
        return response()->json([
            'status' => $revoked,
            'message' => $revoked ? 'Loged out Successfully' : 'Failed To Logout',
        ], $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
