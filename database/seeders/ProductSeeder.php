<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Portátil Gaming MSI',
            'description' => 'Portátil potente para gaming',
            'price' => 1299.99,
            'stock' => 10,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Monitor 27" 144Hz',
            'description' => 'Monitor Full HD 144Hz',
            'price' => 249.99,
            'stock' => 15,
            'category_id' => 2
        ]);

        Product::create([
            'name' => 'Ratón Logitech G502',
            'description' => 'Ratón gaming profesional',
            'price' => 59.99,
            'stock' => 25,
            'category_id' => 3
        ]);
    }
}
