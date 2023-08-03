<?php

namespace App\Http\Livewire\pizza;

use App\Models\Pizza as ModelsPizza;
use Livewire\Component;

class Pizza extends Component
{
    public $pizzas;
    public $pizzaModal = false;
    public $pizza_name;
    public $pizza_img;
    public $pizza_description;
    public $pizza_price;

    public function showModal($id)
    {
        $this->pizzaModal = true;
        $pizza = ModelsPizza::findOrFail($id);
        $this->pizza_name = $pizza->name;
        $this->pizza_img = $pizza->picture;
        $this->pizza_price = $pizza->price;
        $this->pizza_description = $pizza->description;
    }

    public function render()
    {
        $this->pizzas = ModelsPizza::all();

        return view('livewire.pizza.pizza');
    }

    public function successMessage($session, $message)
    {
        return session()->flash($session, $message);

    }

    public function addtocart($id)
    {
        $pizza = ModelsPizza::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['pcs'] += 1;
            $cart[$id]['price'] = $pizza->price * $cart[$id]['pcs'];

        }else{
            $cart[$id] = [
                'pizza_id' => $pizza->id,
                'name' => $pizza->name,
                'pizza_img' => $pizza->picture,
                'price' => $pizza->price,
                'pcs' => 1,
                'description' => $pizza->description
            ];
        }


        session()->put('cart', $cart);
        $this->successMessage('success', 'Add to cart successful');
        $this->emit('refreshCart');
    }

}
