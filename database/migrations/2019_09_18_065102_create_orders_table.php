<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('date');
            $table->bigInteger('address_id')->unsigned();
            $table->Integer('total_price');
            $table->Integer('discount')->nullable();
            $value=array('cash','card');
            $table->enum('payment_method',$value);
            $values=array(1,0);
            $valuess=array(2,1,0);
            $table->enum('payment_status',$values);
            $table->enum('order_status',$valuess);
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
        Schema::dropIfExists('orders');
    }
}
