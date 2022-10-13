<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotification;

class OrderNotificationController extends Controller
{
    //
    public function notify()
    {
        $order = Order::first();
        $notifications = $order->unreadNotifications;
        return view('cms.parent', compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        $order = Order::first();

        $order->unreadNotifications->when(
            $request->input('id'),
            function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            }
        )->markAsRead();

        return response()->noContent();
    }
}
