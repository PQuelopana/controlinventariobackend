<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration{
    
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {   
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->string('email', 50);
            
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
        Schema::dropIfExists('account');
    }
}
