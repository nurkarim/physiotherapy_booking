<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumInAppoimtmentIsPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('appointments', function (Blueprint $table) {
          $table->integer('is_parsonal')->nullable()->after('is_paid');

        });

           Schema::table('invoices', function (Blueprint $table) {
          $table->text('note')->nullable()->after('client_id');

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
