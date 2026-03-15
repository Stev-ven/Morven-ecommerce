<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $token = $request->query('token');

        //find user
        $user  = User::where('verification_token', $token)->first();
        if (!$user) {
            return redirect('/')->with('error', 'Invalid or expired verification link');
        }
        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return redirect('/')->with('success', 'Your email has been verified!');
    }
}
