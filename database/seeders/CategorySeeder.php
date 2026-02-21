<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Ordenadores', 'slug' => 'ordenadores']);
        Category::create(['name' => 'Monitores', 'slug' => 'monitores']);
        Category::create(['name' => 'Ratones', 'slug' => 'ratones']);
        Category::create(['name' => 'Teclados', 'slug' => 'teclados']);
    }
}
