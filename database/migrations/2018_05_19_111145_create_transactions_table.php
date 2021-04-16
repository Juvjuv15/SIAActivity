<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
                $table->string('tid',100)->primary();
                $table->integer('user_fk')->unsigned();
                $table->foreign('user_fk')->references('id')->on('users'); 
                $table->string('lotId_fk',100);
                $table->foreign('lotId_fk')->references('lotId')->on('lots');
                $table->string('sellingType',100);
                $table->integer('lotPrice');
                // $table->string('rightOfWay',100);
                $table->string('paymentType',100)->nullable();
                $table->string('leaseDeposit')->nullable();
                $table->string('contractPeriod',100)->nullable();
                $table->integer('installDownPayment')->nullable(); 
                $table->float('interest',4,2)->nullable();
                $table->string('installPaymentType',100)->nullable();
                $table->string('installTimeToPay',100)->nullable();
                $table->integer('installPayment')->nullable();                                                          
                $table->string('lotDescription',10000)->nullable();
                $table->string('status',200);
                $table->string('sellingStatus',200)->nullable();
                $table->string('count',200)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}