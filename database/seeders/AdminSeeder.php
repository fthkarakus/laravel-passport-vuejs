<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Fatih Karakuş',
            'email' => 'fth_karakus@hotmail.com',
            'student_number' => '',
            'password' => bcrypt('turkai'),
            'role' => 'administrator'
        ]);
    }
}
