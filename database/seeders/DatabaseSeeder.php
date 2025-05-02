<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $properties = [
            Property::create(['name' => 'color']),
            Property::create(['name' => 'brand']),
            Property::create(['name' => 'material']),
        ];

        for ($i = 1; $i <= 100; $i++) {
            $product = Product::create([
                'name' => 'Product ' . $i,
                'price' => rand(10, 100) + rand(0, 99) / 100,
                'quantity' => rand(1, 50),
            ]);

            $product->properties()->attach([
                $properties[0]->id => ['value' => fake()->randomElement(['red', 'blue', 'green'])],
                $properties[1]->id => ['value' => fake()->randomElement(['BrandA', 'BrandB', 'BrandC'])],
                $properties[2]->id => ['value' => fake()->randomElement(['metal', 'plastic', 'wood'])],
            ]);
        }
    }
}