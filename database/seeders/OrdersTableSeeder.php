<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total_price = 300;
        for ($i = 1; $i <= 12; $i++) {
            $order =  Order::create([
                'client_id' => 1,
                'total_price' => $total_price += 100,
                'created_at' => "2023-$i-01 12:24:48",
                'updated_at' => "2023-$i-01 12:24:48"
            ]);
            $order->products()->attach([1, 2], ['quantity' => 2]);
        }
    }
}
