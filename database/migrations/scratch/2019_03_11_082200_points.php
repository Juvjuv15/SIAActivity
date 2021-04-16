<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Points extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tid_fk',100);
            $table->foreign('tid_fk')->references('tid')->on('sellLeasedTransactions');
            $table->string('affordability')->nullable();
            $table->string('establishment')->nullable();
            $table->string('rightofway')->nullable();
            $table->string('location')->nullable();
            $table->string('views')->nullable();
            $table->string('buyintent')->nullable();
            $table->string('leaseintent')->nullable();
            $table->string('actualsale')->nullable();
            $table->string('actualleased')->nullable();
            $table->string('csaleintent')->nullable();
            $table->string('cleaseintent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
}
