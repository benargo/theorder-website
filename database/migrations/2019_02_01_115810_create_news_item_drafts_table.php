<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsItemDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_item_drafts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('news_item_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();

            $table->foreign('news_item_id')
                  ->references('id')->on('news_items')
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
        Schema::dropIfExists('news_item_drafts');
    }
}
