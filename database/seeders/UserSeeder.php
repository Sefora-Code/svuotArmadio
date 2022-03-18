<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
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
        User::factory()->count(20)->create();

        $users = User::all();

        if ($users) {
            foreach ($users as $index => $user) {
                if ($user->hasRole(['super-admin'])) {
                    continue;
                }

                if (($index % 2) === 0) {
                    $user->assignRole(['customer']);

                    Customer::create(['user_id' => $user->id]);
                } else {
                    $user->assignRole(['deliverer']);

                    Employee::create(['hired_on' => now(), 'user_id' => $user->id]);
                }
            }
        }
    }
}
