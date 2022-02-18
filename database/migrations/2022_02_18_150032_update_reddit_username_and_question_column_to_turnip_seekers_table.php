<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRedditUsernameAndQuestionColumnToTurnipSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnip_seekers', function (Blueprint $table) {
            $table->string('reddit_username')->nullable()->change();
            $table->string('custom_answer')->nullable()->change();
        });

        Schema::table('turnip_queues', function (Blueprint $table) {
            $table->string('custom_question')->nullable()->change();
            $table->boolean('ask_reddit_username')->default(true);
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
            $table->string('reddit_username')->change();
            $table->string('custom_answer')->change();
        });

        Schema::table('turnip_queues', function (Blueprint $table) {
            $table->string('custom_question')->change();
            $table->dropColumn('ask_reddit_username');
        });
    }
}
