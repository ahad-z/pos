<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index){
            Stock::create([
                "product_id" => rand(1,20),
                "quantity"   => rand(1,20),
            ]);
        }
    }
}
