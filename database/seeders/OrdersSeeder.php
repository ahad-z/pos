<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index){
            Order::create([
                "cust_id" => rand(1,20),
                "discount_type" => $this->getRandomDiscount(),
                "discount_amount" => 0.2,
                "total" => rand(1,20),
                "paid" => rand(1,20),
                "unpaid" => rand(1,20),
            ]);
        }
    }
    public function getRandomDiscount()
    {
        $discount = array('percent', 'cash');
        return $discount[array_rand($discount)];
    }
}
