<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ms_user_types')->insert([
            'usertype' => 'Admin',
        ]);

        DB::table('ms_user_types')->insert([
            'usertype' => 'Staff',
        ]);

        DB::table('ms_user_types')->insert([
            'usertype' => 'Customer',
        ]);
    }
}
