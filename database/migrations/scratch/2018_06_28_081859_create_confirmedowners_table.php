<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmedownersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmedowners', function (Blueprint $table) {
            $table->increments('oid');
            $table->string('lotId',150);
            $table->foreign('lotId')->references('lotId')->on('lots');
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('userId')->on('users'); 
            $table->string('status',20);
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
        Schema::dropIfExists('confirmedowners');
    }
}
