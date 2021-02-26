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
        User::create([
            'name'=>'Cristian O Mesa',
            'email'=>'cristianmesa13@gmail.com',
            'password'=>bcrypt('1234567')
        ])->assignRole('Admin');


        User::factory(99)->create();
    }
}
