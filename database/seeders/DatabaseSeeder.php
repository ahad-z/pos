<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            /*CategorySeeder::class,
            CustomerSeeder::class,
            BrandSeeder::class,
            UnitsSeeder::class,
            ProductsSeeder::class,
            OrdersSeeder::class,
            OrderDetailsSeeder::class,
            StocksSeeder::class,
            TotalProfitesSeeder::class,
            TotalSellsSeeder::class,
            UnitsSeeder::class,*/
            UsersSeeder::class,
        ]);
    }
}
