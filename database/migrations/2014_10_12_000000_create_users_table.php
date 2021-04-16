<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('userName',50)->nullable();
            $table->string('contact',100)->nullable();
            $table->string('secondaryContact',200)->nullable();
            $table->string('address',200)->nullable();
            $table->string('email',150)->unique();
            $table->string('password',200);
            $table->string('userType',1);
            $table->boolean('userStatus')->nullable();
            $table->string('assessorOffice',100)->nullable();
            $table->rememberToken(10);
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
        Schema::dropIfExists('users');
    }
}
