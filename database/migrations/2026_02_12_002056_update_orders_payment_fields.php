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
            // Change payment_method to string temporarily to avoid enum constraints
            DB::statement('ALTER TABLE orders MODIFY payment_method VARCHAR(255)');
        });
        
        // Update existing data to match new enum values
        DB::table('orders')
            ->whereIn('payment_method', ['cash_on_delivery', 'cash_on_pickup'])
            ->update(['payment_method' => 'payment_on_delivery_or_pickup']);
        
        Schema::table('orders', function (Blueprint $table) {
            // Now change to new enum values
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('payment_on_delivery_or_pickup', 'payment_on_order') NOT NULL");
            
            // Add payment_via field
            $table->string('payment_via')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop payment_via field
            $table->dropColumn('payment_via');
            
            // Change back to string
            DB::statement('ALTER TABLE orders MODIFY payment_method VARCHAR(255)');
        });
        
        // Convert data back
        DB::table('orders')
            ->where('payment_method', 'payment_on_delivery_or_pickup')
            ->update(['payment_method' => 'cash_on_delivery']);
            
        DB::table('orders')
            ->where('payment_method', 'payment_on_order')
            ->update(['payment_method' => 'cash_on_delivery']);
        
        Schema::table('orders', function (Blueprint $table) {
            // Recreate old enum
            DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cash_on_delivery', 'cash_on_pickup') NOT NULL");
        });
    }
};
