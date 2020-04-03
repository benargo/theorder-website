<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuildBankStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guild_bank_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->string('banker_name', 12);
            $table->boolean('is_in_bags');
            $table->integer('bag_number')->nullable();
            $table->integer('slot_number');
            $table->integer('item_id');
            $table->integer('count');
            $table->unsignedInteger('updated_by_user_id');
            $table->timestamps();
            $table->dateTime('withdrawn_at')->nullable();

            // Set up the foreign key to the users table...
            $table->foreign('updated_by_user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('guild_bank_stock');
    }
}
