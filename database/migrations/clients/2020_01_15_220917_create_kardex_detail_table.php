<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexDetailTable extends Migration{
    public function up()
    {
        Schema::create('kardex_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->bigInteger('idKardex')->unsigned()->nullable();;
            $table->integer('item');
            $table->bigInteger('idProduct')->unsigned()->nullable();;
            $table->double('quantity');
            $table->decimal('unitPrice', 12, 5);
            $table->decimal('totalPrice', 15, 5);           
            
            $table->foreign('idKardex')->references('id')->on('kardex');
            $table->foreign('idProduct')->references('id')->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex_detail');
    }
}
