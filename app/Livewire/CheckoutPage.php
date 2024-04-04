<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout')]

class CheckoutPage extends Component
{

    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function placeOrder(){
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',

        ]);
    }

    public function render()
    {
        $cart_itmes = CartManagement::getAllCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_itmes);
        return view('livewire.checkout-page',
        [
            'cart_items' => $cart_itmes,
            'grand_total' => $grand_total,
        ]);
    }
}
