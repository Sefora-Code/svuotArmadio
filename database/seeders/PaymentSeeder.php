<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentType;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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
            Payment::create([
                'amount' => $faker->numberBetween(1, 100),
                'order_id' => $order->id,
                'payment_type_id' => rand(1, PaymentType::class)
            ]);
        }
    }
}
