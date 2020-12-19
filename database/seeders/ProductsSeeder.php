<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,20) as $index){
            Product::create([
                "product_name" => $faker->name,
                "brand_id"     => rand(32,40),
                "cat_id"       => rand(27,30),
                "unit_id"      => rand(41,50),
                "buying_price" => rand(10,20),
                "selling_price" => rand(1,20),
            ]);
        }
    }
}
