<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Notification extends Component
{
    public $notificationsCount;
    public $notifications;

    protected $listeners = ['refreshNotification' => '$refresh'];

    public function markAsRead()
    {
        auth()->user()->notifications->markAsRead();

    }

    public function render()
    {

        $this->notifications = auth()->user()->notifications->take(4);
        $this->notificationsCount = count(auth()->user()->unreadNotifications);
        return view('livewire.user.notification');
    }
}
