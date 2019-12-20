<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidingScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raiding_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day'); // Sunday = 0, Monday = 1, etc...
            $table->time('starts');
            $table->string('tz')->default('Europe/Paris');
            $table->unsignedInteger('raid_id');
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
        Schema::dropIfExists('raiding_schedule');
    }
}
