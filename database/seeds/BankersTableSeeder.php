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
            ['name' => 'Theorder', 'position' => 0, 'created_at' => now()],
            ['name' => 'Herbivore', 'position' => 1, 'created_at' => now()],
            ['name' => 'Garment', 'position' => 2, 'created_at' => now()],
        ]);
    }
}
