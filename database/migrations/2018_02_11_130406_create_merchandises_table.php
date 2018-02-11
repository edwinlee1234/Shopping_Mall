<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 1)->default('C')->comment('C 建立中、S 可販售')->index();
            $table->string('name', 80)->nullable();
            $table->string('name_en', 80)->nullable();
            $table->text('introduction');
            $table->text('introduction_en');
            $table->string('photo', 50)->nullable();
            $table->integer('price')->default(0);
            $table->integer('remain_count')->default(0);
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
        Schema::dropIfExists('merchandises');
    }
}
