<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // checkout info
            $table->string('person_name');
            $table->string('person_email')->nullable();
            $table->string('person_telephone');

            // Order details
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Delivery info
            $table->enum('delivery_option', ['pickup', 'delivery']);
            $table->text('delivery_address')->nullable();

            // Payment info
            $table->enum('payment_method', ['cash_on_delivery', 'cash_on_pickup']);
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');  // pending, paid, failed
            $table->timestamp('paid_at')->nullable();

            // Order status
            $table->enum('order_status', ['pending', 'processing', 'delivered', 'cancelled'])->default('pending');  // pending, processing, shipped, delivered, cancelled
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
