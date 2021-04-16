<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingOwnedLots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendingOwnedLots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('id')->on('users'); 
            $table->string('lotOwner',150)->nullable();
            $table->string('lotNumber',150)->nullable();
            $table->string('lotTitleNumber')->nullable();
            $table->string('lotType')->nullable();
            $table->integer('lotArea')->nullable();
            $table->string('unitOfMeasure',20)->nullable();
            $table->string('lotNorthWestBoundary', 100)->nullable();
            $table->string('lotNorthEastBoundary', 100)->nullable();
            $table->string('lotSouthWestBoundary', 100)->nullable();
            $table->string('lotSouthEastBoundary', 100)->nullable();
            $table->string('lotNorthBoundary', 100)->nullable();
            $table->string('lotSouthBoundary', 100)->nullable();
            $table->string('lotWestBoundary', 100)->nullable();
            $table->string('lotEastBoundary', 100)->nullable();
            $table->string('status', 10)->nullable();
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
        Schema::dropIfExists('pendingOwnedLots');
    }
}
