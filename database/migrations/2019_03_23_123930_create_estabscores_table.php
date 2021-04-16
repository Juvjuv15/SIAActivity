<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstabscoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estabscores', function (Blueprint $table) {
            $table->increments('eId');
            $table->string('estab',50)->nullable();
            $table->integer('escore')->length(20)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estabscores');
    }
    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
     return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
    }
}
