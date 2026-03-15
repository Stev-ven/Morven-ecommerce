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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->foreignId('auth_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('preferred_language')->default('en');
            $table->string('preferred_currency')->default('GHS');
            $table->json('favorite_categories')->nullable();
            $table->json('recently_viewed')->nullable(); // Product IDs
            $table->json('search_history')->nullable();
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->string('theme')->default('light'); // light, dark
            $table->json('custom_settings')->nullable(); // Additional preferences
            $table->timestamps();
            
            $table->index('auth_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
