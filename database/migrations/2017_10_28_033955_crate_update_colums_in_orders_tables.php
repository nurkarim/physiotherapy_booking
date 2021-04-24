<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateUpdateColumsInOrdersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_payment_reference')->nullable()->after('payment_method');
            $table->string('payment_id')->nullable()->after('customer_payment_reference');
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
