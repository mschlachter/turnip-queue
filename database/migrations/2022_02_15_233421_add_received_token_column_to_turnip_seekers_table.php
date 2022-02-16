<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceivedTokenColumnToTurnipSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnip_seekers', function (Blueprint $table) {
            $table->dateTimeTz('received_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('turnip_seekers', function (Blueprint $table) {
            $table->dropColumn('received_code');
        });
    }
}
