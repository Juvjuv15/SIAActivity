<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanoimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panoimages', function (Blueprint $table) {
            $table->increments('panoId');
            $table->string('fileExt',200);
            $table->string('filetype',200);
            // $table->string('tid',25);
            // $table->foreign('tid')->references('tid')->on('transactions');
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
        Schema::dropIfExists('panoimages');
    }
}
