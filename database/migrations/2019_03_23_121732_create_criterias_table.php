<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->increments('cId');
            $table->string('cdesc',20)->nullable();
            $table->integer('cscore')->length(20)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterias');
    }
    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
     return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
    }
}
