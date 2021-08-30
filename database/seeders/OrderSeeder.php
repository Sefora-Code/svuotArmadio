<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {
            Order::create([
                'fullfilled' => rand(1, 100) <= 50,
                'customer_id' => $customer->id
            ]);
        }
    }
}
