<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitMeasureTable extends Migration{
    public function up(){
        Schema::create('unit_measure', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('idAccount')->unsigned()->nullable();
            $table->string('idOfficial', 10);
            $table->string('name', 100);
            $table->string('abbreviation', 5);
            $table->tinyInteger('indActivated');
            
            $table->timestamps();
            
            $table->foreign('idAccount')->references('id')->on('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_measure');
    }
}
