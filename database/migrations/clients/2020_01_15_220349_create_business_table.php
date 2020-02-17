<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration{
    public function up(){
        Schema::create('business', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('idAccount')->unsigned()->nullable();;
            $table->string('identityDocumentNumber', 30);
            $table->string('name', 100);
            
            $table->timestamps();
            
            $table->foreign('idAccount')->references('id')->on('account');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business');
    }
}
