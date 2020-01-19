<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the main 'raids' table...
        Schema::create('raids', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id')->nullable();
            $table->json('instance_ids');
            $table->dateTime('starts_at');
            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();

            $table->foreign('schedule_id')
                  ->references('id')->on('raiding_schedule');
        });

        // Create a new 'raids_signups' link table...
        Schema::create('raids_signups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('raid_id');
            $table->unsignedInteger('user_id');
            $table->string('character_name', 12);
            $table->integer('class_id');
            $table->string('role');
            $table->datetime('signed_up_at');
            $table->dateTime('confirmed_at');
            $table->datetime('withdrawn_at');
            $table->timestamps();

            $table->foreign('raid_id')
                  ->references('id')->on('raids')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raids_signups');
        Schema::dropIfExists('raids');
    }
}