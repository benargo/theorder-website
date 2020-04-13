<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('seniority');
            $table->unsignedInteger('kudos_per_day')->default(0)->nullable();
            $table->unsignedInteger('kudos_required')->default(0);
            $table->bigInteger('discord_role')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('rank_id')->nullable();

            $table->foreign('rank_id')
                  ->references('id')->on('user_ranks')
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
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['rank_id']);
            });
        }

        Schema::dropIfExists('user_ranks');
    }
}
