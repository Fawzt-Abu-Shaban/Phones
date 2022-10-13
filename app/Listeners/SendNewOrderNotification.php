<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admin = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();

        Notification::send($admin, new OrderNotification($event->order));
    }
}
