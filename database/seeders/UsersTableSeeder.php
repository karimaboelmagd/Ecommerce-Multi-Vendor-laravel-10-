<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([

           // Admin

            [
                'full_name'=>'Karim Admin',
                'username'=>'Admin',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('111'),
                'role'=>'admin',
                'status'=>'active',

            ],

            // Seller

            [
                'full_name'=>'Karim Seller',
                'username'=>'Seller',
                'email'=>'seller@gmail.com',
                'password'=>Hash::make('111'),
                'role'=>'seller',
                'status'=>'active',

            ],

            // Customer

            [
                'full_name'=>'Karim Customer',
                'username'=>'Customer',
                'email'=>'customer@gmail.com',
                'password'=>Hash::make('111'),
                'role'=>'customer',
                'status'=>'active',

            ],
        ]);
    }
}
