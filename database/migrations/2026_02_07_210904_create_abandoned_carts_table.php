<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('abandoned_carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('user_id')->index();
            $table->foreignId('auth_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->json('cart_data'); // Full cart contents
            $table->decimal('cart_total', 10, 2);
            $table->integer('items_count');
            $table->string('delivery_option')->nullable();
            $table->timestamp('abandoned_at')->nullable();
            $table->timestamp('recovered_at')->nullable();
            $table->boolean('recovery_email_sent')->default(false);
            $table->timestamp('recovery_email_sent_at')->nullable();
            $table->string('status')->default('abandoned'); // abandoned, recovered, expired
            $table->timestamps();
            
            $table->index(['status', 'abandoned_at']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abandoned_carts');
    }
};
