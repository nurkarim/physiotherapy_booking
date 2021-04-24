<?php

use Illuminate\Database\Seeder;

class VatSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 DB::table('vat_class')->truncate();
        DB::table('vat_class')->insert([

   ['vat_type' => 'BTW','country_id'=>'1','vat_number'=>21,'status'=>1,'created_by'=>1,'updated_by'=>1],

   ['vat_type' => 'BD','country_id'=>'2','vat_number'=>6,'status'=>1,'created_by'=>1,'updated_by'=>1],

    		
        ]);
    }
}
