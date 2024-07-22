<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory(10)->create();

        $stocks = Stock::factory(10)->create();

        $characteristics = Characteristic::factory(10)->create();

        Product::factory(50)->create()->each(function ($product) use ($categories, $stocks, $characteristics) {
            $product->category()->associate($categories->random())->save();

            $product->stocks()->attach(
                $stocks->random(rand(1, 3))->pluck('id')->toArray(),
                ['count' => rand(1, 20)]
            );

            $product->characteristics()->attach(
                $characteristics->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
