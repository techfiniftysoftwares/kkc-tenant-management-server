<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Notifications\UserLoginNotification;

class SendUserLoginNotification
{
    public function handle(UserLoggedIn $event)
    {
        $user = $event->user;
        $user->notify(new UserLoginNotification($user));
    }
}
