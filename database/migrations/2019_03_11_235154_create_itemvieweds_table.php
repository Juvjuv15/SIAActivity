<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemviewedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemvieweds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('id')->on('users');
            $table->string('lotId_fk',100);
            $table->foreign('lotId_fk')->references('lotId')->on('lots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itemvieweds');
    }
}
