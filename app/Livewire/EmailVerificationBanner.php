<?php

namespace App\Livewire;

use App\Mail\AccountVerificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EmailVerificationBanner extends Component
{
    use LivewireAlert;
    public $dismissed = false;

    public function mount()
    {
        $this->dismissed = session('verification_banner_dismissed', false);
    }

    public function dismiss()
    {
        $this->dismissed = true;
        session(['verification_banner_dismissed' => true]);
    }

    public function sayHello(){
        dd('hello');
    }

    public function resendVerification()
    {   
        // dd('dd');
        /** @var \App\Models\User $user */
        //find user
        $user = Auth::user();
        $new_verification_token = Str::random(40);

        if (!$user) {
            $this->alert('error', 'account not found');
        }

        try {
            Mail::to($user->email)->send(new AccountVerificationMail($new_verification_token));
            $user->verification_token = $new_verification_token;
            $user->save();
            $message = 'Verification link has been sent to your account';
        } catch (\Exception $e) {
            Log::error('Failed to resend verification notification: ' . $e->getMessage());
            $message = 'Something went wrong; Please try again';
        }

        $this->flash('success', $message);
        $this->dismiss();
        $this->dispatch('userLoggedIn');
    }

    public function render()
    {
        return view('livewire.email-verification-banner');
    }
}
