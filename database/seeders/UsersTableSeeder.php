<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = [
            'name' => 'João',
            'username' => 'joao10',
            'email' => 'joao.silva@gmail.com',
            'phone' => '124123131',
            'password' => 'joao'
        ];

        User::create($user);
    }
}
