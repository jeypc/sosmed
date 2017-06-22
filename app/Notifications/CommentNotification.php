<?php

namespace App\Notifications;

use Auth;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;

    private $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $status)
    {
        $this->comment = $comment;
        $this->status = $status;
        /*
            Status
                1 = from your friend to you
                2 = from your friends to you
                3 = from you to your friend
        */
    }

    public function message()
    {
        if ($this->comment->user->gender == '1') {
            $call = 'his';
        } else {
            $call = 'her';
        }

        switch($this->status) {
            case '1':
                $message = ' commented on your post';
                break;
            case '2':
                $message = ' and 2 other commented on your post';
                break;
            case '3':
                $message = ' commented on '.$call.' post';
                break;
            default:
                $message = ' ';
                break;
        }

        return $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'status' => 'comment',
            'name' => $this->comment->user->name,
            'message' => $this->message()
        ];
    }
}
