<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('nickname', 32)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('battletag', 255);
            $table->string('discord_user_id', 255)->nullable();
            $table->string('bnet_access_token', 255)->nullable();
            $table->dateTime('bnet_access_token_expires')->nullable()->default(Carbon::now()->addDays(30));
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
