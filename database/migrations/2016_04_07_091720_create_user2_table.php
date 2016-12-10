<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('user2s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NameOfCompany')->nullable();
            $table->string('NameOfPresident')->nullable();
            $table->string('NameOfPerson');
			$table->enum('Type', array('Individual', 'Corporation'));
            $table->longText('Address');
            $table->string('Tel');
             $table->string('Email')->unique();
            $table->string('password');
            $table->string('Sex')->nullable();
			$table->date('EstablishDate')->nullable();
            $table->longText('BusinessSummary');
             $table->string('RegistrationCertificate')->nullable();
             $table->string('IndividualCertificate')->nullable();
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
        Schema::drop('user2s');
        //
    }
}
