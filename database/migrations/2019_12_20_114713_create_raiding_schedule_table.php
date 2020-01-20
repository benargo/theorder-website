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
            $table->dateTimeTz('starts');
            $table->unsignedInteger('repeats_days')->nullable();
            $table->unsignedInteger('num_tanks')->nullable();
            $table->unsignedInteger('num_tanks_druid')->nullable();
            $table->unsignedInteger('num_tanks_paladin')->nullable();
            $table->unsignedInteger('num_tanks_warrior')->nullable();
            $table->unsignedInteger('num_healers')->nullable();
            $table->unsignedInteger('num_healers_druid')->nullable();
            $table->unsignedInteger('num_healers_paladin')->nullable();
            $table->unsignedInteger('num_healers_priest')->nullable();
            $table->unsignedInteger('num_damage')->nullable();
            $table->unsignedInteger('num_damage_druid')->nullable();
            $table->unsignedInteger('num_damage_hunter')->nullable();
            $table->unsignedInteger('num_damage_mage')->nullable();
            $table->unsignedInteger('num_damage_paladin')->nullable();
            $table->unsignedInteger('num_damage_priest')->nullable();
            $table->unsignedInteger('num_damage_rogue')->nullable();
            $table->unsignedInteger('num_damage_warlock')->nullable();
            $table->unsignedInteger('num_damage_warrior')->nullable();
            $table->json('instance_ids');
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
