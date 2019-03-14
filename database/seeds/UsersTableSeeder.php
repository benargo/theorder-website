<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1922840,
            'nickname' => 'Saromius',
            'battletag' => encrypt('Animorphus#2491'),
            'rank_id' => 1,
        ]);
    }
}
