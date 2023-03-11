<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach([
            [
                'name' => 'Administrator',
                'email' => 'admin@localhost',
                'password' => password_hash('1', PASSWORD_DEFAULT),
                'role_id' => 1
            ],
            [
                'name' => 'Knowledge Engineer',
                'email' => 'ke@localhost',
                'password' => password_hash('1', PASSWORD_DEFAULT),
            ]
        ] as $credentials) User::create($credentials);
    }
}
