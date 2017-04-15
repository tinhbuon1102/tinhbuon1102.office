<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBookedspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookedspaces', function (Blueprint $table) {
            $table->text('EnterDetails');
            $table->text('ExitDetails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookedspaces', function (Blueprint $table) {
            $table->dropColumn('EnterDetails');
            $table->dropColumn('ExitDetails');
        });
    }
}
