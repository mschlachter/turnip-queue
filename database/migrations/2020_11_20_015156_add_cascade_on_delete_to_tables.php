<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeOnDeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnip_queues', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('turnip_queues_user_id_foreign');
            }
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
        Schema::table('turnip_seekers', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('turnip_seekers_turnip_queue_id_foreign');
            }
            $table->foreign('turnip_queue_id')
                ->references('id')->on('turnip_queues')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('turnip_queues', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('turnip_queues_user_id_foreign');
            }
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
        Schema::table('turnip_seekers', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('turnip_seekers_turnip_queue_id_foreign');
            }
            $table->foreign('turnip_queue_id')
                ->references('id')->on('turnip_queues');
        });
    }
}
