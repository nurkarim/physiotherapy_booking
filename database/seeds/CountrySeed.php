<?php

use Illuminate\Database\Seeder;

class CountrySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('countryes')->truncate();
        
       DB::table('countryes')->insert([
            ['name' => 'Belgium','code'=>'BWT'],
            ['name' => 'Bangladesh','code'=>'BD']
    		
        ]);
    }
}
