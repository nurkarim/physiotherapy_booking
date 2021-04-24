<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeekTypesDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('week_types_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week_type_id');
            $table->integer('day_id');
            $table->string('start_time');
            $table->string('end_time');
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
