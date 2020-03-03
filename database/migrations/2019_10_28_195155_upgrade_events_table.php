<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgradeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_all_day')->after('ends_at')->default(false);
            $table->renameColumn('starts_at', 'start');
        });

        // Split this functionality into its own function for SQLite support...
        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('ends_at', 'end');
        });

        // Drop the 'event_attendees' and 'event_invitees' tables...
        Schema::dropIfExists('event_attendees');
        Schema::dropIfExists('event_invitees');

        // Create a new 'event_users' link table...
        Schema::create('event_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('user_id');
            $table->datetime('invited_at');
            $table->datetime('accepted_at');
            $table->datetime('declined_at');

            $table->foreign('event_id')
                  ->references('id')->on('events')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('event_users');
    }
}
