<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiusscoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiusscores', function (Blueprint $table) {
            $table->increments('rId');
            $table->string('rdesc',20)->nullable();
            $table->integer('rscore')->length(20)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radiusscores');
    }
    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
     return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
    }
}
