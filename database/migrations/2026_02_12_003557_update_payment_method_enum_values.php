<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Change payment_method to string temporarily
            DB::statement('ALTER TABLE orders MODIFY payment_method VARCHAR(255)');
        });
        
        // Update existing data
        DB::table('orders')
            ->where('payment_method', 'payment_on_delivery_or_pickup')
            ->update(['payment_method' => 'payment_on_delivery']);
        
        Schema::table('orders', function (Blueprint $table) {
            // Now change to new enum values with three options
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('payment_on_delivery', 'payment_on_pickup', 'paid_on_order') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Change back to string
            DB::statement('ALTER TABLE orders MODIFY payment_method VARCHAR(255)');
        });
        
        // Convert data back
        DB::table('orders')
            ->whereIn('payment_method', ['payment_on_delivery', 'payment_on_pickup'])
            ->update(['payment_method' => 'payment_on_delivery_or_pickup']);
            
        DB::table('orders')
            ->where('payment_method', 'paid_on_order')
            ->update(['payment_method' => 'payment_on_order']);
        
        Schema::table('orders', function (Blueprint $table) {
            // Recreate old enum
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('payment_on_delivery_or_pickup', 'payment_on_order') NOT NULL");
        });
    }
};
