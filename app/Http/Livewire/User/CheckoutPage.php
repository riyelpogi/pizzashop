<?php

namespace App\Http\Livewire\User;

use App\Events\NewOrder;
use App\Models\billingAddress;
use App\Models\ReceiverDetails;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Livewire\Component;

class CheckoutPage extends Component
{
    public $user;
    public $carts;
    public $total_price;

    public $changeAddressModal = false;

    public $country;
    public $city;
    public $province;
    public $region;
    public $postal_id;
    public $barangay;
    public $address;

    public $newcountry;
    public $newcity;
    public $newprovince;
    public $newregion;
    public $newpostal_id;
    public $newbarangay;
    public $newaddress;

    public $payment_method;
    public $receiver_name;
    public $receiver_mobile_number;

    protected $rules = [
        'country' => 'required',
        'city' => 'required',
        'province' => 'required',
        'region' => 'required',
        'postal_id' => 'required',
        'barangay' => 'required',
        'address' => 'required',

    ];

    public function checkout()
    {
        $this->validate(
            [
                'payment_method' => 'required',
                'receiver_name' => 'required',
                'receiver_mobile_number' => ['required','min:11','max:11']
            ]
        );

        $cart = session()->get('cart', []);

        if ($this->payment_method == 'cod') {
            $shipping_address = auth()->user()->billing_address;
        
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

        if (!$this->user->receiver_detail) {
            $receiver_detail = ReceiverDetails::create([
                'user_id' => auth()->user()->id,
                'receiver_name' => $this->receiver_name,
                'receiver_mobile_number' => $this->receiver_mobile_number,
            ]);

        }else{
              if($this->user->receiver_detail->receiver_name != $this->receiver_name || $this->user->receiver_detail->receiver_mobile_number != $this->receiver_mobile_number){
            $detail = ReceiverDetails::where('user_id', auth()->user()->id);
            $detail->receiver_name = $this->receiver_name;
            $detail->receiver_mobile_number = $this->receiver_mobile_number;
            $detail->save();
        }
    }
        
        $address = $shipping_address->country. "," .$shipping_address->province . ",". $shipping_address->city. ",".$shipping_address->region. ",".$shipping_address->posta_id. ",".$shipping_address->barangay. ",".$shipping_address->street_name;

        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'orders' => $orders,
            'price' => $this->total_price,
            'billing_address' => $address,
            'payment_method' => $this->payment_method,
            'status' => 'pending',
            'receiver_name' => $this->receiver_name,
            'receiver_number' => $this->receiver_mobile_number
        ]);
        if ($transaction) {

            $admin =  User::where('role', 1)->first();
            event(new NewOrder($admin));

            $notify = [
                'admin_id' => $admin->id,
            ];
            $admin->notify(new NewOrderNotification($notify));
        }
        session()->pull('cart');
        
           return redirect()->to('/dashboard')->with('success', 'Order successful');
        }else{
            return redirect()->to("/checkout/card/$this->total_price/$this->receiver_name/$this->receiver_mobile_number");
        }
        
    }

    public function saveAddress()
    {
        $this->validate();

            $saveAddress = billingAddress::create(
                [
                    'user_id' => auth()->user()->id,
                    'country' => $this->country,
                    'city' => $this->city,
                    'province' => $this->province,
                    'region' => $this->region,
                    'postal_id' => $this->postal_id,
                    'barangay' => $this->barangay,
                    'street_name' => $this->address,
                ]
                );

    }

    public function render()
    {
        $this->user = auth()->user();
        $amount = 0;
        if(session()->has('cart')){
        $this->carts = session()->get('cart');
        foreach ($this->carts as $cart) {
            $amount += $cart['price'];
             }
        }

        if ($this->user->receiver_detail) {
            $this->receiver_name = $this->user->receiver_detail->receiver_name; 
            $this->receiver_mobile_number = $this->user->receiver_detail->receiver_mobile_number; 
        }

        $this->total_price = $amount;
        return view('livewire.user.checkout-page');
    }

    public function changeAddress()
    {
        $this->changeAddressModal = true;
        $address = billingAddress::where('user_id', $this->user->id)->first();

        $this->newcountry = $address->country;
        $this->newcity = $address->city;
        $this->newprovince = $address->province;
        $this->newregion = $address->region;
        $this->newpostal_id = $address->postal_id;
        $this->newbarangay = $address->barangay;
        $this->newaddress = $address->street_name;
    }

    public function saveNewAddress()
    {
        $this->validate([
                'newcountry' => 'required',
                'newcity' => 'required',
                'newprovince' => 'required',
                'newregion' => 'required',
                'newpostal_id' => 'required',
                'newbarangay' => 'required',
                'newaddress' => 'required',
            ]);
        $s = billingAddress::where('user_id', auth()->user()->id)->first();
        $address = billingAddress::findOrFail($s->id);
        $address->country = $this->newcountry;
        $address->city = $this->newcity;
        $address->province = $this->newprovince;
        $address->region = $this->newregion;
        $address->postal_id = $this->newpostal_id;
        $address->barangay = $this->newbarangay;
        $address->street_name = $this->newaddress;
        $address->save();
        $this->reset();
        

       
    }
}
