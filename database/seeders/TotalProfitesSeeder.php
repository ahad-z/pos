<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TotalProfites;

class TotalProfitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index){
            TotalProfites::create([
                "amount" => rand(1,20)
            ]);
        }
    }
}
