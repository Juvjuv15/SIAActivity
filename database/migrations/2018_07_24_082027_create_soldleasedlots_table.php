<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldLeasedLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soldleasedlots', function (Blueprint $table) {
            $table->increments('soldleased_id');
            // $table->string('buyerid',100);                
            $table->integer('user_fk')->unsigned();
            // $table->string('user_fk',50);
            $table->foreign('user_fk')->references('id')->on('users');
            $table->string('tid_fk',50);           
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
        Schema::dropIfExists('soldleasedlots');
    }
}
