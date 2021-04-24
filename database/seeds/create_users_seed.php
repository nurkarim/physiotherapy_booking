<?php

use Illuminate\Database\Seeder;

class create_users_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->truncate();
      
        DB::table('users')->insert([
            ['first_name' => 'admin','last_name' => 'admin','email' => 'admin@gmail.com', 'password' => bcrypt('admin'),'vat_number' => '0','user_type' => '1','phone_number' => '00000000000','status'=>1],
    		['first_name' => 'murad','last_name' => 'rezaul','email' => 'murad@gmail.com', 'password' => bcrypt('admin'),'vat_number' => '0','user_type' => '1','phone_number' => '00000000000','status'=>1]
        ]);
    }
}
