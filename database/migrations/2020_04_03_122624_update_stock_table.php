<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the boolean for is_in_bags...
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->dropColumn('is_in_bags');
        });

        // Drop the timestamp for withdrawn_at...
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->dropColumn('withdrawn_at');
        });

        // Add a new column for mailbox items...
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->integer('mail')->nullable()->after('bag_number');
        });

        // Rename bag_number and slot_number...
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->renameColumn('bag_number', 'bag');
        });
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->renameColumn('slot_number', 'slot');
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
            // Restore the boolean column for is_in_bags...
            $table->boolean('is_in_bags')->default(true);
        });

        Schema::table('guild_bank_stock', function (Blueprint $table) {
            // Drop the column for mail_number
            $table->dropColumn('mail');
        });

        // Reverse the renaming...
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->renameColumn('bag', 'bag_number');
        });
        Schema::table('guild_bank_stock', function (Blueprint $table) {
            $table->renameColumn('slot', 'slot_number');
        });
    }
}
