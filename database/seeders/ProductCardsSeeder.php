<?php

namespace Database\Seeders;

use App\Models\ProductCards;
use Illuminate\Database\Seeder;

class ProductCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing cards
        ProductCards::truncate();

        // Main hero slides with high-quality ecommerce images
        $mainCards = [
            [
                'title' => 'Summer Collection 2024',
                'description' => 'Discover the latest trends in fashion',
                'image_path' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&q=80',
                'is_main' => true,
            ],
            [
                'title' => 'Premium Sneakers',
                'description' => 'Step up your game with exclusive footwear',
                'image_path' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1920&q=80',
                'is_main' => true,
            ],
            [
                'title' => 'Limited Edition Kicks',
                'description' => 'Rare sneakers for the true collector',
                'image_path' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=1920&q=80',
                'is_main' => true,
            ],
            [
                'title' => 'Exclusive Deals',
                'description' => 'Up to 50% off on selected items',
                'image_path' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1920&q=80',
                'is_main' => true,
            ],
        ];

        // Sub cards for other sections
        $subCards = [
            [
                'title' => 'Men\'s Collection',
                'description' => 'Stylish and comfortable menswear',
                'image_path' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?w=800&q=80',
                'is_main' => false,
            ],
            [
                'title' => 'Women\'s Collection',
                'description' => 'Elegant and trendy fashion',
                'image_path' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&q=80',
                'is_main' => false,
            ],
        ];

        // Insert main cards
        foreach ($mainCards as $card) {
            ProductCards::create($card);
        }

        // Insert sub cards
        foreach ($subCards as $card) {
            ProductCards::create($card);
        }

        $this->command->info('Product cards seeded successfully!');
    }
}
