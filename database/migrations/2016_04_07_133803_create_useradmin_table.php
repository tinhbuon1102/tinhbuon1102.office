<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseradminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useradmins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name')->nullable();
          $table->string('Email')->unique();
            $table->string('UserName')->unique();
            $table->string('password');
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
        Schema::drop('useradmins');
    }
}
