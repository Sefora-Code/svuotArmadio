<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // crea il ruolo 'super amministratore'
        Role::create(['name' => 'super-admin']);

        // crea il ruolo 'amministratore'
        Role::create(['name' => 'admin']);

        // crea il ruolo 'fattorino'
        Role::create(['name' => 'deliverer']);

        // crea il ruolo 'cliente'
        Role::create(['name' => 'customer']);
    }
}
