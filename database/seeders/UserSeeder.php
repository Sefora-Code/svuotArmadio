<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        $users = User::all();

        if ($users) {
            foreach ($users as $user) {
                if ($user->hasRole(['super-admin'])) {
                    continue;
                }

                $user->assignRole(['customer']);
            }
        }
    }
}
