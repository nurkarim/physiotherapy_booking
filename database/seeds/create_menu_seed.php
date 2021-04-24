<?php

use Illuminate\Database\Seeder;

class create_menu_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         DB::table('menu')->truncate();
       DB::table('menu')->insert([
            ['menu_name' => 'Appointment','icon'=>'fa  fa-plus-square fa-fw','route'=>'javascript::void()','status'=>1,'has_sub_menu'=>1],

            ['menu_name' => 'Order List','icon'=>'fa  fa-cart-arrow-down fa-fw','route'=>'orders','status'=>1,'has_sub_menu'=>0],
            ['menu_name' => 'invoices List','icon'=>'fa  fa-cart-arrow-down fa-fw','route'=>'invoices','status'=>1,'has_sub_menu'=>0], 
            ['menu_name' => 'Credit Note List','icon'=>'fa  fa-cart-arrow-down fa-fw','route'=>'creditList','status'=>1,'has_sub_menu'=>0],   
            ['menu_name' => 'Products','icon'=>'fa  fa-product-hunt fa-fw','route'=>'javascript::void()','status'=>1,'has_sub_menu'=>1],

            ['menu_name' => 'General Setting','icon'=>'fa   fa-co fa-fw','route'=>'genarel-settings','status'=>1,'has_sub_menu'=>0],  
            ['menu_name' => 'Setting','icon'=>'fa   fa-cog fa-fw','route'=>'javascript::void()','status'=>1,'has_sub_menu'=>1],

            ['menu_name' => 'Availability','icon'=>'fa   fa-cog fa-fw','route'=>'javascript::void()','status'=>1,'has_sub_menu'=>0],   

            ['menu_name' => 'Users','icon'=>'fa   fa-user-plus fa-fw','route'=>'users','status'=>1,'has_sub_menu'=>0], 

            ['menu_name' => 'Wallet Requests','icon'=>'fa   fa-credit-card fa-fw','route'=>'wallet-requests','status'=>1,'has_sub_menu'=>0],
    	
        ]);
    }
}
