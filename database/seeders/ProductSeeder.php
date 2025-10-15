<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
        public function run(): void
    {
        Product::create([
            'name' => 'laptop',
            'price' => 2200.00,
        ]);
        Product::create([
            'name' => 'keyboard',
            'price' => 200.00,
        ]);
        Product::create([
            'name' => 'mobile',
            'price' => 3500.00,
        ]);
        Product::create([
            'name' => 'mouse',
            'price' => 80.00,
        ]);
        
    }
}
