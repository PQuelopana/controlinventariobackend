<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTable extends Migration
{
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('idEstablishment')->unsigned()->nullable();;
            $table->string('name', 100);
            
            $table->timestamps();
            
            $table->foreign('idEstablishment')->references('id')->on('establishment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse');
    }
}
