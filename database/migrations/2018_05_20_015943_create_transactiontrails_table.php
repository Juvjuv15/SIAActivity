<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactiontrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactiontrails', function (Blueprint $table) {
            $table->string('trailId',150)->primary();
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('id')->on('users');
            $table->string('tid_fk',100);
            $table->foreign('tid_fk')->references('tid')->on('transactions');
            $table->string('actions',200);   
            $table->string('status',20)->nullable();    
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
        Schema::dropIfExists('transactiontrails');
    }
}
