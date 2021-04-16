<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTertiarySectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tertiarysectors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',100);
            $table->string('name',100);
            $table->float('lng',30,27);
            $table->float('lat',30,27);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tertiary_sectors');
    }
}
