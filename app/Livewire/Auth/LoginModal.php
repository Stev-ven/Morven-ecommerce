<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LoginModal extends Component
{
    use LivewireAlert;

    public $email = '';
    public $password = '';
    public $remember = false;
    public $showModal = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.email' => 'Please enter a valid email address (e.g., user@example.com)',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters long.',
    ];

    protected $listeners = ['showLoginModal' => 'show'];

    public function show()
    {
        $this->showModal = true;
        $this->reset(['email', 'password', 'remember']);
    }

    public function hide()
    {
        $this->showModal = false;
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->alert('success', 'Welcome back!');
            $this->hide();
            $this->dispatch('userLoggedIn');
            
            // Refresh the page to update UI
            return redirect()->to(request()->header('Referer') ?? route('home'));
        }

        $this->alert('error', 'Invalid credentials. Please try again.');
    }

    public function switchToRegister()
    {
        $this->hide();
        $this->dispatch('showRegisterModal');
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
