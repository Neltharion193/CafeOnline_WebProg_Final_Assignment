<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ms_users')->insert([
            'user_type_id' => '1',
            'fullname' => 'AdminOps',       
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'address' => 'Jl. Admin Jaya No. 11',
            'gender' => 'male'
        ]);
    }
}
