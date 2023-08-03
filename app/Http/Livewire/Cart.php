<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Cart extends Component
{
    public $cartCount;
    protected $listeners = ['refreshCart' => '$refresh'];
    
    public function render()
    {
        if (session()->get('cart')) {
            $this->cartCount = count(session()->get('cart'));
        }

        return view('livewire.cart');
    }
}
