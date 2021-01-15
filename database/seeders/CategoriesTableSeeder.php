<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'uncategories' , 'status'=> 1   ]);
        Category::create(['name' => 'Natural' , 'status'=> 1   ]);
        Category::create(['name' => 'flowers' , 'status'=> 1   ]);
        Category::create(['name' => 'Kitechen' , 'status'=> 0  ]);
    }
}
