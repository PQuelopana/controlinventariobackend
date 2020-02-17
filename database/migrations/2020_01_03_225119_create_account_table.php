<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration{
    protected $system = true;
    
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {   
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');
            $table->string('email', 50);
            $table->string('password', 200);
            $table->bigInteger('idHostName')->unsigned()->nullable();
            
            $table->timestamps();
            
            $table->foreign('idHostName')->references('id')->on('hostnames');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
