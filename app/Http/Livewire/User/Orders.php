<?php

namespace App\Http\Livewire\User;

use App\Models\Transaction;
use Livewire\Component;

class Orders extends Component
{
    protected $orders;

    public function render()
    {
        $this->orders = Transaction::where('user_id', auth()->user()->id)->get();
        return view('livewire.user.orders', ['orders' => $this->orders]);
    }
}
