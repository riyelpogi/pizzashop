<?php

namespace App\Http\Livewire\Admin;

use App\Models\Transaction;
use Livewire\Component;

class OrderHistory extends Component
{
    protected $orderHistory;
    public $orders;

    public function render()
    {
        $this->orderHistory = Transaction::where('status', 'delivered')
                                            ->where('date_delivered', '!=', null)
                                            ->get();
        $this->orders = $this->orderHistory;
        return view('livewire.admin.order-history');
    }
}
