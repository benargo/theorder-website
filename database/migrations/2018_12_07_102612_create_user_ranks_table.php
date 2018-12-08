<?php

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
            $table->integer('kudos_per_day')->default(0);
            $table->integer('kudos_required')->default(0);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_rank_id_foreign');
        });

        Schema::dropIfExists('user_ranks');
    }
}
