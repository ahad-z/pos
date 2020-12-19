<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
class UnitsSeeder extends Seeder
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
            Unit::create([
                "unit"  => rand(1, 20)
            ]);
        }
    }
}
