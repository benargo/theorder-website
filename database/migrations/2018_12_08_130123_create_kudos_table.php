<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kudos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('awarded_by_user_id')->nullable();
            $table->unsignedInteger('awarded_to_user_id');
            $table->string('reason');
            $table->timestamps();

            $table->foreign('awarded_by_user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('awarded_to_user_id')
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
        Schema::dropIfExists('kudos');
    }
}
