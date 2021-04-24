<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_name');
            $table->decimal('amount', 8, 2);
            $table->string('color')->nullable();
            $table->integer('max_person');
            $table->integer('vat_number');
            $table->integer('has_variable_price')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
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
