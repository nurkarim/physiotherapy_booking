<?php

use Illuminate\Database\Seeder;

class TimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('times')->truncate();
         DB::table('times')->insert([
            ['name' => '07:00','status'=>1],
    		
    		['name' => '08:00','status'=>1],
    
    		['name' => '09:00','status'=>1],
   
            ['name' => '10:00','status'=>1],
 
    		['name' => '11:00','status'=>1],

            ['name' => '12:00','status'=>1],
   
            ['name' => '13:00','status'=>1],
            ['name' => '14:00','status'=>1],

            ['name' => '15:00','status'=>1],

            ['name' => '16:00','status'=>1],

            ['name' => '17:00','status'=>1],

    		['name' => '18:00','status'=>1],
    		['name' => '19:00','status'=>1],
    		['name' => '20:00','status'=>1],
    		['name' => '21:00','status'=>1],
        ]);
    }
}
