<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('user_id');
            $table->string('order_no');
            $table->integer('vat_number');
            $table->decimal('vat_amount', 8, 2);
            $table->decimal('sub_total', 8, 2);
            $table->decimal('wallet_paid', 8, 2);
            $table->decimal('total', 8, 2);
            $table->integer('is_wallet');
            $table->integer('is_paid');
            $table->string('payment_method')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('order_note')->nullable();
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
