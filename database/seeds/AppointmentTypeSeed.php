<?php

use Illuminate\Database\Seeder;

class AppointmentTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('appointment_types')->truncate();
         DB::table('appointment_types')->insert([
            ['type_name' => 'Appointment type 1','amount'=>60,'max_person'=>1,'vat_number'=>6,'created_by'=>1,'updated_by'=>1,'status'=>1],
    		['type_name' => 'Appointment type 2','amount'=>60,'max_person'=>1,'vat_number'=>6,'created_by'=>1,'updated_by'=>1,'status'=>1],
    		['type_name' => 'Appointment type 3','amount'=>60,'max_person'=>1,'vat_number'=>6,'created_by'=>1,'updated_by'=>1,'status'=>1],
    		['type_name' => 'Appointment type 4','amount'=>60,'max_person'=>1,'vat_number'=>6,'created_by'=>1,'updated_by'=>1,'status'=>1],
    		['type_name' => 'Appointment type 5','amount'=>60,'max_person'=>1,'vat_number'=>6,'created_by'=>1,'updated_by'=>1,'status'=>1],
    		['type_name' => 'Appointment type 6','amount'=>60,'max_person'=>1,'vat_number'=>6,'created_by'=>1,'updated_by'=>1,'status'=>1],
    		
        ]);
    }
}
