<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiusrangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiusranges', function (Blueprint $table) {
            $table->increments('radiusId');
            $table->string('radiusdesc',50)->nullable();
            $table->integer('radiuskm')->length(20)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radiusranges');
    }
    public function integer($column, $autoIncrement = false, $unsigned = false)
    {
     return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
    }
}
