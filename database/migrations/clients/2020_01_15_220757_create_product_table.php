<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->integer('idBusiness')->unsigned()->nullable();
            $table->string('idInternal', 10);
            $table->string('name', 100);
            $table->integer('idUnitMeasure')->unsigned()->nullable();
            $table->double('stockMinimun');
            
            $table->timestamps();
            
            $table->foreign('idBusiness')->references('id')->on('business');
            $table->foreign('idUnitMeasure')->references('id')->on('unit_measure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
