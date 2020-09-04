<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnipSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnip_seekers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('turnip_queue_id')->constrained();
            $table->string('reddit_username');
            $table->string('in_game_username');
            $table->string('island_name');
            $table->string('custom_answer');
            $table->string('token');
            $table->dateTimeTz('joined_queue');
            $table->dateTimeTz('last_ping');
            $table->boolean('left_queue')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnip_seekers');
    }
}
