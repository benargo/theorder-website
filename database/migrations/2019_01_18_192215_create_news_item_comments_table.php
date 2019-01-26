<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsItemCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_item_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type')
            $table->timestamps();

            $table->foreign('author_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict');
        });

        Schema::table('news_items', function (Blueprint $table) {
            $table->boolean('allows_comments')
                  ->after('body')
                  ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news_items', function(Blueprint $table) {
            $table->dropColumn('allows_comments');
        });

        Schema::dropIfExists('news_item_comments');
    }
}
