<?php

namespace App\Http\Livewire\User;

use App\Models\billingAddress;
use Livewire\Component;

class Cartlist extends Component
{
    public $carts;
    public $total_price;

    public $user;

    protected $intent;

    public $country;
    public $city;
    public $province;
    public $region;
    public $postal_id;
    public $barangay;
    public $address;

    public $payment_methods; 
    protected $rules = [
        'country' => 'required',
        'city' => 'required',
        'province' => 'required',
        'region' => 'required',
        'postal_id' => 'required',
        'barangay' => 'required',
        'address' => 'required',

    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }


    public function showPlaceOrderModal()
    {
        $this->placeOrderModal = true;
    }
    protected $listener = ["refreshPrice" => "refreshPrice" ];

    public function refreshPrice()
    {
        if(session()->get('cart')){
            foreach ($this->carts as $cart) {
                $this->total_price += $cart['price'];
            }
      }
    }

    public function removeOnCart($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);

        session()->put('cart',$cart);
        $this->emit('refreshPrice');    
        $this->emit('refreshCart');
        session()->flash('success', 'Delete successful');
    }


    public function render()
    {    
        $amount = 0;
         if(session()->has('cart')){
        $this->carts = session()->get('cart');
        foreach ($this->carts as $cart) {
            $amount += $cart['price'];
             }
        }

        return view('livewire.user.cartlist', ['intent' => $this->intent]);
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

}
