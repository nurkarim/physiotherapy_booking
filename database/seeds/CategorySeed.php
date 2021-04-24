<?php

use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('categories')->truncate();
        
       DB::table('categories')->insert([
            ['name' => 'category-1','image'=>'1-20171005031706D910.png'],
            ['name' => 'category-2','image'=>'2-20171005032014B175.png'],

        ]);
    }
}
