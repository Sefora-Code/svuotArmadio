<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // bici cargo da 50kg di carico
        VehicleType::create([
            'name' => 'Cargo bike da 50kg'
        ]);

        // bici cargo elettrica da 100kg di carico
        VehicleType::create([
            'name' => 'Cargo e-bike da 100kg'
        ]);

        // Furgoncino
        VehicleType::create([
            'name' => 'Fiat Fiorino'
        ]);
    }
}
