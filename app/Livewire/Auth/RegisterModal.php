<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountVerificationMail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RegisterModal extends Component
{
    use LivewireAlert;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email:rfc,dns|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    protected $messages = [
        'email.email' => 'Please enter a valid email address (e.g., user@example.com)',
        'email.unique' => 'This email is already registered. Please sign in instead.',
        'password.min' => 'Password must be at least 8 characters long.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    protected $listeners = ['showRegisterModal' => 'show'];

    public function show()
    {
        $this->showModal = true;
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
    }

    public function hide()
    {
        $this->showModal = false;
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'verification_token' => Str::random(40),
        ]);

        Auth::login($user);

        // Send verification notification (like password reset)
        try {
            Mail::to($user->email)->send(new AccountVerificationMail($user->verification_token));
            $message = 'Account created successfully! Please check your email to verify your account.';
        } catch (\Exception $e) {
            Log::error('Failed to send verification notification: ' . $e->getMessage());
            $message = 'Account created successfully! Please verify your email address.';
        }

        $this->flash('success', $message);
        $this->hide();
        $this->dispatch('userLoggedIn');

        // Refresh the page to update UI
        return redirect()->to(request()->header('Referer') ?? route('home'));
    }

    public function switchToLogin()
    {
        $this->hide();
        $this->dispatch('showLoginModal');
    }

    public function render()
    {
        return view('livewire.auth.register-modal');
    }
}
