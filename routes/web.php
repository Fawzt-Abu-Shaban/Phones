<?php

use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\OrderNotificationController;
use App\Http\Controllers\permissionsController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('cms.index2');
// });

Route::prefix('mobile')->middleware('guest:admin,user')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('mobile.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('mobile.register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::prefix('mobile/admin')->middleware(['auth:admin', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', permissionsController::class);
    Route::resource('permission/roles', PermissionRoleController::class);
    Route::resource('permission/user', UserPermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::get('globalSearch', [SearchController::class, 'globalSearch'])->name('globalSearch');
    Route::get('search', [SearchController::class, 'searching'])->name('searching');
    Route::get('invoice', function () {
        return view('cms.order.invoiceprint');
    })->name('invoice');
});



// Route::post('markAsRead/{id}', [OrderNotificationController::class, 'markAsRead'])->name('markAsRead');


Route::prefix('mobile/admin')->middleware(['auth:admin,user', 'verified'])->group(function () {
    Route::get('/', [DashBoardController::class, 'showDashBoard'])->name('dashboard');
    Route::resource('product', ProductController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('type', TypeController::class);

    Route::get('changepassword', [AuthController::class, 'showChangePassword'])->name('mobile.changepass');
    Route::post('changepassword', [AuthController::class, 'changePassword']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('mobile.logout');
});

// Route::prefix('mail')->group(function () {
//     Route::get('welcome', function () {
//         return new WelcomeEmail();
//     });
// });

//////////////////////////////////////////////// Verify Email
Route::get('/email/verify', function () {
    return view('cms.auth.verify-email');
})->middleware('auth:admin,user')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mobile/admin');
})->middleware(['auth:admin,user', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    // return back()->with('message', 'Verification link sent!');
    return response()->json(['message' => 'Verification link sent!']);
})->middleware(['auth:admin,user', 'throttle:6,1'])->name('verification.send');


//////////////////////////////////////////////// Reset Password
Route::get('/forgot-password', function () {
    return view('cms.auth.forgot-password');
})->middleware('guest:user')->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest:user')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('cms.auth.reset-password', ['token' => $token]);
})->middleware('guest:user')->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest:user')->name('password.update');
