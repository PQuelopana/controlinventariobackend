<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentTable extends Migration{
    public function up()
    {
        Schema::create('establishment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('idBusiness')->unsigned()->nullable();
            $table->string('name', 100);
            
            $table->timestamps();
            
            $table->foreign('idBusiness')->references('id')->on('business');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('establishment');
    }
}
