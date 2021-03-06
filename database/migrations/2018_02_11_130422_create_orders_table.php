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
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('total_price')->nullable();
            $table->string('pay_type', 3)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('name', 200)->nullable();
            $table->string('status', 1)->default('C')->comment('C 購物車、N 沒付款、Y 己付款、X 取消訂單');
            $table->string('process', 1)->default('N')->comment('N 待處理、I 處理中、D 已出貨');
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
