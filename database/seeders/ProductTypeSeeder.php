<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ms_product_types')->insert([
            'producttype' => 'Main Course',
        ]);

        DB::table('ms_product_types')->insert([
            'producttype' => 'Dessert',
        ]);

        DB::table('ms_product_types')->insert([
            'producttype' => 'Beverages',
        ]);
    }
}
