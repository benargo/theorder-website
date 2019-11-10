<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->boolean('is_invite_only')->default(false);
            $table->unsignedInteger('created_by_user_id');
            $table->timestamps();

            $table->foreign('created_by_user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
        });

        // The migration to create the 'event_attendees' and 'event_invitees'
        // tables have been removed...
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_attendees');
        Schema::dropIfExists('event_invitees');
        Schema::dropIfExists('events');
    }
}
