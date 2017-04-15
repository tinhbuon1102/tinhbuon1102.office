<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUser1sharespacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user1sharespaces', function (Blueprint $table) {
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
        Schema::table('user1sharespaces', function (Blueprint $table) {
            $table->dropColumn('EnterDetails');
            $table->dropColumn('ExitDetails');
        });
    }
}
