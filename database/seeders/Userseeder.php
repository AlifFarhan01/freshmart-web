<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' =>'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role'=>'admin',

            ],
              [
                'name' => 'user',
                'email' =>'user@gmail.com',
                'password' => bcrypt('user123'),
                'role'=>'user',

            ],
            ]);
    }
}
