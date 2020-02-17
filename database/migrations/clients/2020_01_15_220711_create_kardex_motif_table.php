<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexMotifTable extends Migration{
    public function up()
    {
        Schema::create('kardex_motif', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('idAccount')->unsigned()->nullable();
            $table->string('type', 1);
            $table->string('name', 100);
            
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
        Schema::dropIfExists('kardex_motif');
    }
}
