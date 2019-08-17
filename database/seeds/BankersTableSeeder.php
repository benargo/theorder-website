<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bankers')->insert([
            ['name' => 'Theorder', 'order' => 0],
            ['name' => 'Herbivore', 'order' => 1],
            ['name' => 'Garment', 'order' => 2],
        ]);
    }
}
