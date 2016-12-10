<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user1s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NameOfCompany');
            $table->string('NameOfPresident');
            $table->string('NameOfPerson');
            $table->longText('Address');
            $table->string('Tel');
             $table->string('Email')->unique();
            $table->string('password');
			$table->date('EstablishDate');
            $table->longText('BusinessSummary');
            $table->string('HashCode')->nullable();
            $table->string('EmailVerificationText')->nullable();
			$table->integer('Status');
			$table->enum('IsEmailVerified', array('Yes', 'No'))->default('No');
			$table->enum('IsAdminApproved', array('Yes', 'No'))->default('No');
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
        Schema::drop('user1s');
    }
}
