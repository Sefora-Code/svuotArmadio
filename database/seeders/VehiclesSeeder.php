<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++)
        {
            Vehicle::create([
                'bought_on' => date('Y-m-d'),
                'vehicle_type_id' => rand(1, VehicleType::count())
            ]);
        }
    }
}
