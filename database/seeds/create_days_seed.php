<?php

use Illuminate\Database\Seeder;

class create_days_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('days')->truncate();
         DB::table('days')->insert([
            ['name' => 'Monday','status'=>1],
    		['name' => 'Tuesday','status'=>1],
    		['name' => 'Wednesday','status'=>1],
    		['name' => 'Thursday','status'=>1],
    		['name' => 'Friday','status'=>1],
    		['name' => 'Saturday','status'=>1],
    		['name' => 'Sunday','status'=>1]
        ]);
    }
}
