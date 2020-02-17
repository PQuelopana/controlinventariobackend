<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexTable extends Migration{
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->integer('idWarehouse')->unsigned()->nullable();;
            $table->integer('idKardexMotif')->unsigned()->nullable();;
            $table->bigInteger('idInternal');
            $table->date('date');
            $table->time('hour');
            
            $table->timestamps();
            
            $table->foreign('idWarehouse')->references('id')->on('warehouse');
            $table->foreign('idKardexMotif')->references('id')->on('kardex_motif');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex');
    }
}
