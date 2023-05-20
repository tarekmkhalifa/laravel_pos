<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use CategoriesTableSeeder;
use ClientsTableSeeder;
use Database\Seeders\CategoriesTableSeeder as SeedersCategoriesTableSeeder;
use Database\Seeders\ClientsTableSeeder as SeedersClientsTableSeeder;
use Database\Seeders\ProductsTableSeeder as SeedersProductsTableSeeder;
use Illuminate\Database\Seeder;
use Laratrust\Laratrust;
use ProductsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SeedersCategoriesTableSeeder::class);
        $this->call(SeedersProductsTableSeeder::class);
        $this->call(SeedersClientsTableSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
