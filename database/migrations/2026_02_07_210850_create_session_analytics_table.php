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
        Schema::create('session_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('user_id')->index();
            $table->foreignId('auth_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->string('current_page')->nullable();
            $table->string('referrer')->nullable();
            $table->json('page_views')->nullable(); // Array of visited pages
            $table->integer('total_page_views')->default(0);
            $table->timestamp('first_visit_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('session_duration')->default(0); // in seconds
            $table->boolean('is_suspicious')->default(false);
            $table->string('device_type')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable();
            $table->string('platform')->nullable(); // OS
            $table->timestamps();
            
            $table->index(['user_id', 'last_activity_at']);
            $table->index('is_suspicious');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_analytics');
    }
};
