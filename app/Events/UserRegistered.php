<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  $user;
    public  $code;

    /**
     * UserRegistered constructor.
     * @param User $user
     * @param string $code
     */
    public function __construct(User $user,string $code)
    {
        Log::info('Event Triggered: User Registered & Sending Email and Sms');
        $this->user = $user;
        $this->code = $code;
    }

}
