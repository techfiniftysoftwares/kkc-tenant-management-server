<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
{
    return ['database', 'broadcast'];
}
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'login_time' => now()->toDateTimeString(),
            'notifiable_id' => $notifiable->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'login_time' => now()->toDateTimeString(),
            'notifiable_id' => $notifiable->id,
        ]);
    }

    public function broadcastOn()
    {
        return ['user-logins'];
    }
}
