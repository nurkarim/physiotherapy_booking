<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('order_id');
            $table->integer('start_time_id');
            $table->integer('specialist_id');
            $table->integer('appointment_type_id');
            $table->date('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('appointment_type');
            $table->text('time_and_appointmnet_name');
            $table->decimal('price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('vat_price', 8, 2);
            $table->string('vat_number')->nullable();
            $table->integer('recurring')->nullable();
            $table->integer('interval')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
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
