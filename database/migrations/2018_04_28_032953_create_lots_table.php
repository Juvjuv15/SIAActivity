<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->string('lotId',100)->primary();
            $table->string('lotNumber',200);
            $table->string('lotTitleNumber',200)->nullable();
            $table->string('lotAddress',100);
            $table->string('lotOwner',100);
            $table->string('lotCornerInfluence',3);
            $table->string('lotType',100);
            $table->float('lotArea',30,4);
            $table->string('unitOfMeasure',200);
            $table->integer('lotUnitValue');
            $table->integer('lotAdjustment');
            $table->string('rightOfWay',200);
            $table->integer('lotMarketValue')->nullable();
            $table->string('mortgage',3)->nullable();
            $table->string('lotNEBoundary',100)->nullable();
            $table->string('lotNWBoundary',100)->nullable();
            $table->string('lotSEBoundary',100)->nullable();
            $table->string('lotSWBoundary',100)->nullable();
            $table->string('lotNBoundary',100)->nullable();
            $table->string('lotEBoundary',100)->nullable();
            $table->string('lotSBoundary',100)->nullable();
            $table->string('lotWBoundary',100)->nullable();
            $table->float('lat',20,17)->nullable();
            $table->float('lng',20,17)->nullable();
            $table->integer('cityAdmin')->unsigned();
            $table->foreign('cityAdmin')->references('id')->on('users');
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
