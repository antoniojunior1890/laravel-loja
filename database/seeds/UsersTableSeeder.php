<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
        *User::create([
        *    'name'     => 'Antonio Junior',
        *    'email'    => 'antonio@email.com',
        *    'password' => bcrypt('123456'),
        *]);
        *User::create([
        *    'name'     => 'Valdinar Aroucha',
        *    'email'    => 'valdinarp@email.com',
        *    'password' => bcrypt('123456'),
        *]); 
        */
        User::create([
            'name'     => 'Usuario',
            'email'    => 'usuario@email.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
