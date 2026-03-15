<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\EmailVerificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class ViewLastVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:view-verification {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preview the verification email for a user (defaults to last registered user)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->error("User with email '{$email}' not found.");
                return 1;
            }
        } else {
            // Get the last registered user
            $user = User::latest('created_at')->first();
            
            if (!$user) {
                $this->error('No users found in the database.');
                return 1;
            }
        }

        $this->info("Generating verification email preview for: {$user->name} ({$user->email})");
        $this->newLine();

        // Generate verification URL
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            [
                'id' => $user->id,
                'hash' => sha1($user->email)
            ]
        );

        // Create the mailable
        $mailable = new EmailVerificationMail($user, $verificationUrl);
        
        // Render the email HTML
        $html = $mailable->render();
        
        // Save to temporary file
        $tempFile = storage_path('app/temp_verification_email.html');
        file_put_contents($tempFile, $html);
        
        $this->info("Email preview saved to: {$tempFile}");
        $this->info("Open this file in your browser to view the email.");
        $this->newLine();
        
        // Display verification URL
        $this->info("Verification URL:");
        $this->line($verificationUrl);
        $this->newLine();
        
        // Display email details
        $this->table(
            ['Property', 'Value'],
            [
                ['Subject', 'Email Verification Mail'],
                ['To', $user->email],
                ['User Name', $user->name],
                ['User ID', $user->id],
                ['Created At', $user->created_at->format('Y-m-d H:i:s')],
                ['Email Verified', $user->hasVerifiedEmail() ? 'Yes' : 'No'],
            ]
        );

        return 0;
    }
}
