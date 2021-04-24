<?php

use Illuminate\Database\Seeder;

class SubMenuSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('sub_menu')->truncate();
    	DB::table('sub_menu')->insert([
        ['menu_id' => '1','sub_menu_name'=>'Add Appointment','icon'=>'fa  fa-plus-square fa-fw','route'=>'appointments/create/new','status'=>1], 
        ['menu_id' => '1','sub_menu_name'=>'Appointment List','icon'=>'fa  fa-plus-square fa-fw','route'=>'appointments','status'=>1],
         ['menu_id' => '1','sub_menu_name'=>'Appointment Types','icon'=>'fa  fa-plus-square fa-fw','route'=>'appointment/types','status'=>1],    

         ['menu_id' => '5','sub_menu_name'=>'Product List','icon'=>'fa  fa-plus-square fa-fw','route'=>'products','status'=>1],
         ['menu_id' => '5','sub_menu_name'=>'Add Product','icon'=>'fa  fa-plus-square fa-fw','route'=>'products/create','status'=>1],    


         ['menu_id' => '7','sub_menu_name'=>'Add Role','icon'=>'fa  fa-plus-square fa-fw','route'=>'roles','status'=>1],
         ['menu_id' => '7','sub_menu_name'=>'Add country','icon'=>'fa  fa-plus-square fa-fw','route'=>'country','status'=>1],
         ['menu_id' => '7','sub_menu_name'=>'company setting','icon'=>'fa  fa-plus-square fa-fw','route'=>'setting/company','status'=>1],

 ]);
    }
}
