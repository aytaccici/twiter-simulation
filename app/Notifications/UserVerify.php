<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UserVerify extends Notification
{
    use Queueable;

    protected  $user;

    protected  $code;


    /**
     * UserVerify constructor.
     * @param User $user
     * @param string $code
     */
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail',SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Verify User')
                    ->line('Dear '.$this->user->surname.', Your conformation code :'. $this->code)
                    ->line('Thank you for using our application!');
    }


    /**
     * @param $notifiable
     */
    public function toSms($notifiable)
    {
        Log::info('Dear '.$this->user->surname.', Verify Code  is : '. $this->code);
    }
}
