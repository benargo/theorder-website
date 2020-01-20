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
            $table->dateTime('starts_at');
            $table->dateTime('cancelled_at')->nullable();
            $table->unsignedInteger('schedule_id')->nullable();
            $table->json('instance_ids');
            $table->timestamps();

            $table->foreign('schedule_id')
                  ->references('id')->on('raiding_schedule')
                  ->onDelete('cascade');
        });

        // Create a new 'raids_signups' link table...
        Schema::create('raids_signups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('raid_id');
            $table->unsignedInteger('user_id');
            $table->string('character_name', 12);
            $table->integer('class_id');
            $table->string('role');
            $table->dateTime('confirmed_at')->nullable();
            $table->datetime('withdrawn_at')->nullable();
            $table->timestamps();

            $table->foreign('raid_id')
                  ->references('id')->on('raids')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('no action');
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
