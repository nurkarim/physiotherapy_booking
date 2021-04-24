<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateAppointmentTableColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('appointments', function (Blueprint $table) {
            $table->string('name')->nullable()->after('vat_number');
            $table->text('location')->nullable()->after('name');
            $table->string('week_note')->nullable()->after('interval');
            $table->string('week_time')->nullable()->after('week_note');
            $table->integer('is_cancel')->nullable()->after('week_time');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
