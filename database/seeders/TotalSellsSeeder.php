<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TotalSell;

class TotalSellsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index){
            TotalSell::create([
               "order_id" => rand(1,20),
               "amounts"  => rand(1,20)
            ]);
        }

    }
}
