<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrdersDetail;

class OrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,20) as $index){
            OrdersDetail::create([
                "order_id" => rand(1,20),
                "product_id" => rand(1,20),
                "discount_type" => $this->getRandomDiscount(),
                "discount_amount" => 0.2,
                "quantity" => rand(1,20),
            ]);
        }
    }
    public function getRandomDiscount()
    {
        $discount = array('percent', 'cash');
        return $discount[array_rand($discount)];
    }
}
