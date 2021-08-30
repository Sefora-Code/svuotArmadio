<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $orders = Order::all();

        foreach ($orders as $order) {
            OrderDetail::create([
                'shipping_address' => $order->customer->user->address,
                'volume' => $faker->numberBetween(1, 100),
                'notes' => $faker->text,
                'order_id' => $order->id
            ]);
        }
    }
}
