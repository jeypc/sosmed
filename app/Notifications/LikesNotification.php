<?php

namespace App\Notifications;

use App\Like;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LikesNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $like;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($like, $user)
    {
        $this->like = $like;
        $this->user = $user;
    }

    public function message() {
        $like_count = Like::where('post_id')->count();

        if ($like_count <= 1) {
            return ' liked your post.';
        } else {
            return ' and '.($like_count - 1).' other liked your post.';
        }
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
                    ->line($this->user->name .' '. $this->message())
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
            'status' => 'like',
            'name' => $this->user->name,
            'message' => $this->message(),
            'like' => $this->like
        ];
    }
}
