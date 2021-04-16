<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlotusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plotusers', function (Blueprint $table) {
            $table->string('userid',25)->primary();
            $table->string('fullname',100);
            $table->string('address',100);
            $table->string('email',100)->unique;
            $table->string('password',255);
            $table->string('remember_token',255)->nullable();
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
        Schema::dropIfExists('plotusers');
    }
}
