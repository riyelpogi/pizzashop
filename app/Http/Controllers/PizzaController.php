<?php

namespace App\Http\Controllers;

use App\Models\ReceiverDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use App\Events\NewOrder;
use App\Models\User;
use App\Notifications\NewOrderNotification;

class PizzaController extends Controller
{
    public function showCart()
    {
        return view('user.cart');
    }

    public function checkout()
    {
        return view('user.checkoutpage');
    }

    public function cardCheckout($total_pice,$receiver_name, $receiver_mobile_number)
    {
        return view('cardcheckout', ['intent' => auth()->user()->createSetupIntent(), 'total_price' => $total_pice, 'receiver_name' => $receiver_name, 'receiver_number' => $receiver_mobile_number]);
    }

    public function cardPayment(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();
        $shipping_address = $user->billing_address;

        
        try {

        $cart = session()->get('cart', []);


            $user->createOrGetStripeCustomer();
            $paymentMethod = $request->payment_method;
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
                  
             $orders = [];

              foreach (session()->get('cart') as $value) {
                $pizza = [
                        'pizza_id' => $value['pizza_id'],
                        'pizza_name' => $value['name'],
                        'pizza_img' => $value['pizza_img'],
                        'price' => $value['price'],
                        'pcs' => $value['pcs']
                    ];
                    
                  array_push($orders, $pizza);
                 }

                

            $address = $shipping_address->country. ",".$shipping_address->province . ",". $shipping_address->city. ",".$shipping_address->region. ",".$shipping_address->postal_id. ",".$shipping_address->barangay. ",".$shipping_address->street_name;

            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'orders' => $orders,
                'price' => $request->total_price,
                'billing_address' => $address,
                'payment_method' => 'card',
                'status' => 'pending',
                'receiver_name' => $request->receiver_name,
                'receiver_number' => $request->receiver_number
                
            ]);

            if($payment = $user->charge($request->total_price * 100, $paymentMethod->id,[
                'currency' => 'php',
                'description' => 'Payment for transaction id ' . $transaction->id . ' Name ' . $request->receiver_name . ' mobile number ' . $request->receiver_number
            ])){
                $transaction->payment_status = 'paid';
                $transaction->save(); 
                $admin =  User::where('role', 1)->first();
                 event(new NewOrder($admin));

                $notify = [
                    'admin_id' => $admin->id,
                ];
                $admin->notify(new NewOrderNotification($notify));
            }


            if (!$user->receiver_detail) {
                $receiver_detail = ReceiverDetails::create([
                    'user_id' => auth()->user()->id,
                    'receiver_name' => $request->receiver_name,
                    'receiver_mobile_number' => $request->receiver_number,
                ]);
    
            }else{
                  if($user->receiver_detail->receiver_name != $request->receiver_name || $user->receiver_detail->receiver_mobile_number != $request->receiver_number){
                $detail = ReceiverDetails::where('user_id', auth()->user()->id)->first();
                $detail->receiver_name = $request->receiver_name;
                $detail->receiver_mobile_number = $request->receiver_number;
                $detail->save();
            }
        }

            session()->pull('cart');

            return redirect('/dashboard')->with('success', 'Order successful');
        } catch (\Throwable $th) {
            return redirect('/dashboard')->with('error', $th);
        }




    }   

    public function orders()
    {
        return view('user.orders');
    }

}
