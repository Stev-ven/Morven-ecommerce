<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CheckoutOptionsModal extends Component
{
    public $showModal = false;
    public $redirectRoute = '';

    protected $listeners = ['showCheckoutOptions' => 'show'];

    public function show($route = 'placeOrder')
    {
        $this->redirectRoute = $route;
        $this->showModal = true;
    }

    public function hide()
    {
        $this->showModal = false;
    }

    public function continueAsGuest()
    {
        $this->hide();
        $checkoutInfo = Session::get('checkout_info', []);
        $checkoutInfo['checkout_as'] = 'guest';
        Session::put('checkout_info', $checkoutInfo);
        // dd(Session::get('checkout_info'));
        return redirect()->route($this->redirectRoute);
    }

    public function showLogin()
    {
        $this->hide();
        $this->dispatch('showLoginModal');
    }

    public function showRegister()
    {
        $this->hide();
        $this->dispatch('showRegisterModal');
    }

    public function render()
    {
        return view('livewire.auth.checkout-options-modal');
    }
}
