<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricescoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricescores', function (Blueprint $table) {
            $table->increments('pId');
            $table->string('pdesc',20)->nullable();
            $table->integer('pscore')->length(20)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricescores');
    }
    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
     return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
    }
}
