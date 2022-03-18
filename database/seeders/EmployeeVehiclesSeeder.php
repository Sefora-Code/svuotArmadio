<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeVehicle;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class EmployeeVehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all();

        $vehicles = Vehicle::all();

        if ($employees && $vehicles) {
            foreach ($employees as $employee) {
                EmployeeVehicle::create([
                    'employee_id' => $employee->id,
                    'vehicle_id' => rand(1, $vehicles->count()),
                    'assigned_by' => 1
                ]);
            }
        }

    }
}
