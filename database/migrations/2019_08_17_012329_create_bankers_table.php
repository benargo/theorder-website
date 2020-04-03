<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 12)->unique();
            $table->unsignedInteger('position');
            $table->timestamps();
        });

        Schema::table('guild_bank_stock', function (Blueprint $table) {
            // Drop the column 'banker_name' from the stock table...
            $table->dropColumn('banker_name');
        });
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            // Insert a new column 'banker_id' after the 'id' field...
            $table->unsignedInteger('banker_id')
                ->after('id')
                ->default(0);

            // Add a foreign key to reference the new 'bankers' table...
            $table->foreign('banker_id')
                  ->references('id')->on('bankers')
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
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->dropForeign('guild_bank_stock_banker_id_foreign');
            $table->dropColumn('banker_id');
            $table->string('banker_name', 12)->default('{unknown}');
        });

        Schema::dropIfExists('bankers');
    }
}
