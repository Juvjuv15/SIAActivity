<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lothistories', function (Blueprint $table) {
            $table->string('hId')->primary();
            // $table->string('lotNumber');
            $table->string('lotId',150);
            $table->foreign('lotId')->references('lotId')->on('lots');
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('id')->on('users'); 
            $table->string('oldOwner',200);
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
        Schema::dropIfExists('lothistories');
    }
}
