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
            [
                'id' => 1922840,
                'nickname' => 'Tinkletoes',
                'battletag' => encrypt('Animorphus#2491'),
                'rank_id' => 1,
            ],
            [
                'id' => 51425995,
                'nickname' => 'Ninjaa',
                'battletag' => encrypt('Ninjaa1337#2904'),
                'rank_id' => 1,
            ],
        ]);
    }
}
