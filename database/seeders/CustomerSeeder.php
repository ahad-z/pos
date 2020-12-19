<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
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
            Customer::create([
                "cust_name" => $faker->name,
                "cust_phone"=> $faker->phoneNumber,
                "cust_address"=> $faker->address
            ]);
        }
    }
}
