<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('contractid');
            // $table->string('tid',100);
            $table->integer('user_fk')->unsigned();
            $table->foreign('user_fk')->references('id')->on('users'); 
            $table->string('tid_fk',100);
            // $table->integer('tid_fk')->unsigned();
            $table->foreign('tid_fk')->references('tid')->on('transactions');
            // -------------------------------------
            $table->date('dateexecuted')->nullable();
            $table->string('owner')->nullable();
            $table->string('leaserbuyer')->nullable();
            // -----------------------------------
            $table->date('datesold')->nullable();
            $table->string('paymenttype')->nullable();
            $table->float('contractprice',20,2)->nullable();
            // ---------------------------------
            $table->date('startcontract')->nullable();
            $table->date('endcontract')->nullable();
            $table->string('contractperiod',20)->nullable();
            $table->float('amortprice',20,2)->nullable();
            $table->string('leasedeposit',200)->nullable();
            $table->float('downpayment',20,2)->nullable();
            $table->float('interest',4,2)->nullable();
            $table->string('installpaymenttype',100)->nullable();
            $table->string('installtimetopay',100)->nullable();
            $table->integer('installpayment')->nullable();   
            $table->string('status',20)->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
