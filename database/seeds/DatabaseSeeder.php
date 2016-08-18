<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['name' => 'admin']);
        DB::table('roles')->insert(['name' => 'user']);

        User::create([
            'name' => 'John Doe',
            'email' => 'j.doe@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
        ])->assignRole('admin');

        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@gmail.com',
            'password' => bcrypt('password'),
            'remember_token' => str_random(10),
        ])->assignRole('user');
    }
}
