<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItempurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itempurchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('id')->on('users');
            $table->string('tid_fk',100);
            $table->foreign('tid_fk')->references('tid')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itempurchases');
    }
}
