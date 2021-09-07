<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

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
                'vehicle_type_id' => rand(1,3)
            ]);    
        }
    }
}
