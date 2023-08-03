<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDeliveryNotification extends Notification implements ShouldBroadcast
{
    use Queueable;
    public $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */

    public function toDatabase(object $notifiable)
    {
        return [
            'user_id' => $this->user['user_id'],
            'order_id' => $this->user['order_id'],
            'message' => "Your order is being deliver"
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

     public function toBroadcast(object $notifiable)
     {
        return new BroadcastMessage([
            'message' => "Your order is being deliver"

        ]);
     }

    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user['id'],
            'order_id' => $this->user['order_id'],
            'message' => "Your order is being deliver"
        ];
    }
}
