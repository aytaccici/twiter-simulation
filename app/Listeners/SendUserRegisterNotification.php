<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\UserVerify;


class SendUserRegisterNotification
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $event->user->notify(new UserVerify($event->user,$event->code));
    }
}
