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
        // First, update existing data to match new categories
        // Map old categories to new ones (default to 'clothing' for now)
        DB::table('products')->whereIn('category', ['men', 'women', 'kids'])->update(['category' => 'clothing']);
        
        // Drop the old enum constraints and recreate with new values
        DB::statement("ALTER TABLE products MODIFY COLUMN category VARCHAR(255)");
        DB::statement("ALTER TABLE products MODIFY COLUMN subcategory VARCHAR(255) NULL");
        
        // Update category to enum with new values
        DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM('clothing', 'footwear', 'accessories', 'activewear', 'grooming') NOT NULL");
        
        // Remove the old color and size columns (they're now arrays in colors and sizes)
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('products', 'size')) {
                $table->dropColumn('size');
            }
        });
        
        // Ensure colors and sizes columns exist as JSON
        if (!Schema::hasColumn('products', 'colors')) {
            Schema::table('products', function (Blueprint $table) {
                $table->json('colors')->nullable()->after('brand');
            });
        }
        
        if (!Schema::hasColumn('products', 'sizes')) {
            Schema::table('products', function (Blueprint $table) {
                $table->json('sizes')->nullable()->after('colors');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert category to old enum values
        DB::statement("ALTER TABLE products MODIFY COLUMN category VARCHAR(255)");
        DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM('clothing', 'footwear', 'accessories', 'grooming') NOT NULL");
        
        // Add back old columns
        Schema::table('products', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->string('size')->nullable();
        });
    }
};
