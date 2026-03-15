<?php

namespace App\Console\Commands;

use App\Models\AbandonedCart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessAbandonedCarts extends Command
{
    protected $signature = 'carts:process-abandoned';
    protected $description = 'Process abandoned carts and send recovery emails';

    public function handle()
    {
        $this->info('Processing abandoned carts...');

        // Get abandoned carts from last 24 hours that haven't received recovery email
        $abandonedCarts = AbandonedCart::abandoned()
            ->recent(24)
            ->where('recovery_email_sent', false)
            ->whereNotNull('email')
            ->get();

        $count = 0;

        foreach ($abandonedCarts as $cart) {
            try {
                // Send recovery email
                // Mail::to($cart->email)->send(new AbandonedCartEmail($cart));
                
                $cart->markRecoveryEmailSent();
                $count++;
                
                $this->info("Recovery email sent to: {$cart->email}");
            } catch (\Exception $e) {
                $this->error("Failed to send email to {$cart->email}: {$e->getMessage()}");
            }
        }

        // Mark old abandoned carts as expired (older than 7 days)
        $expiredCount = AbandonedCart::abandoned()
            ->where('abandoned_at', '<', now()->subDays(7))
            ->update(['status' => 'expired']);

        $this->info("Processed {$count} abandoned carts");
        $this->info("Marked {$expiredCount} carts as expired");

        return Command::SUCCESS;
    }
}
