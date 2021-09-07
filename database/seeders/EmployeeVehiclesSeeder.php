<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\EmployeeVehicle;
use App\Models\Employee;

class EmployeeVehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = Vehicle::all()->toArray();
        if (count($vehicles) > 0)
        {
            for ($i = 0; $i < count($vehicles); $i++) 
            {
                EmployeeVehicle::create([
                    'employee_id' => $i+1,
                    'vehicle_id' => $vehicles[$i]['id'],
                    'assigned_by' => 1
                ]);
            }
        }
        
    }
}
