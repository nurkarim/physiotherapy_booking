<?php

use Illuminate\Database\Seeder;

class CompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('company_info')->truncate();
        
       DB::table('company_info')->insert([
           'id_number'=>123,
			'name'=>"Jenkine",
			'post_code'=>"OH 45402",
			'city'=>"Dayton",
			'address'=>"3818 Harter Street Dayton, OH 45402",
			'email'=>" info@jenkin.be",
			'contact'=>"+3324234233242",
			'vat_number'=>"B4234",
			'bank_account_number'=>"32422434",
			'country'=>"Belgium",
    		
        ]);
    }
}
