<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumInAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       Schema::table('appointments', function (Blueprint $table) {
          $table->string('sourch')->nullable()->after('enddateTime');
          $table->integer('is_paid')->nullable()->after('is_cancel');
          $table->integer('is_order')->nullable()->after('is_paid');
          $table->decimal('shippment_cost', 8, 2)->nullable()->after('sourch');
          $table->integer('is_wallet')->nullable()->after('shippment_cost');
          $table->text('note')->nullable()->after('is_order');
          $table->decimal('grand_vat', 8, 2)->nullable()->after('note');
          $table->decimal('grand_total', 8, 2)->nullable()->after('grand_vat');
          $table->decimal('grand_total_with_vat', 8, 2)->nullable()->after('grand_total');


        });

   Schema::table('appointments', function (Blueprint $table) {
    $table->dropColumn('order_id');   
   });
       
Schema::table('order_product_cart', function (Blueprint $table) {
    $table->dropColumn('order_id');   
});

       Schema::table('order_product_cart', function (Blueprint $table) {
   
          $table->integer('order_id')->nullable()->after('id');
          $table->integer('appointment_id')->nullable()->after('order_id');
 
        });
         Schema::table('orders', function (Blueprint $table) {
          $table->integer('appoitment_id')->nullable()->after('user_id');
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
