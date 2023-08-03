<?php

namespace App\Http\Livewire\Admin;

use App\Models\Transaction;
use App\Models\User;
use App\Notifications\OrderDeliveryNotification;
use Laravel\Cashier\Cashier;
use Livewire\Component;

class Orderlist extends Component
{
    protected $ordersarray;
    public $orders;
    public $admin;
    public $readyToLoad = false;

    public function getListeners()
    {
        return [
            "echo-private:Admin.{$this->admin->id},NewOrder" => 'notifyNewOrder'
        ];
    }

    public function notifyNewOrder($data)
    {
    }

    public function LoadTransactions()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $this->admin = auth()->user();
        $this->ordersarray = Transaction::where('status', '!=', 'delivered')
                                          ->where('date_delivered', null)
                                          ->where('status', '!=', 'canceled')
                                          ->orderBy('created_at', 'desc')->get();
        $this->orders = $this->ordersarray;
        $this->readyToLoad = $this->orders;

        return view('livewire.admin.orderlist');
    }   

    public function preparing($id)
    {
        $order = Transaction::findOrFail($id);
        $order->status = "preparing";
        $order->save();
    }

    public function delivered($id)
    {
        $time = time();
        $order = Transaction::findOrFail($id);
        
        $order->status = "delivered";
        if ($order->payment_status == 'not paid') {
            $order->payment_status = 'paid';
        }
        $order->date_delivered = date('Y-m-d', $time);
        $order->save();
    }

    public function delivering($id)
    {
        $order = Transaction::findOrFail($id);

        $user = User::findOrFail($order->user_id);

        $notifyUser = [
            'user_id' => $user->id,
            'order_id' => $order->id
        ];

        $user->notify(new OrderDeliveryNotification($notifyUser));
        
        $order->status = "delivering";
        $order->save();
    }

    public function cancelOrder($id)
    {
        $order = Transaction::findOrFail($id);
        $order->status = "canceled";
        $order->save();
    }
}
