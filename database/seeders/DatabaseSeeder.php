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
        $this->call(RoleSeeder::class);

        $this->call(SuperAdminSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(PaymentTypeSeeder::class);

        $this->call(OrderSeeder::class);

        $this->call(OrderDetailSeeder::class);
        
        $this->call(PaymentSeeder::class);
        
        $this->call(VehicleTypesSeeder::class);
        
        $this->call(VehiclesSeeder::class);

        $this->call(EmployeeVehiclesSeeder::class);
    }
}
