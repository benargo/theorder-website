<?php

use Illuminate\Database\Seeder;

class UserRanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_ranks')->insert([
            // ['title' => 'Grand Master', 'seniority' => 0],
            ['title' => 'Inner Circle', 'seniority' => 1],
            ['title' => 'Class Leader – Druid', 'seniority' => 2],
            ['title' => 'Class Leader – Hunter', 'seniority' => 2],
            ['title' => 'Class Leader – Mage', 'seniority' => 2],
            ['title' => 'Class Leader – Paladin', 'seniority' => 2],
            ['title' => 'Class Leader – Priest', 'seniority' => 2],
            ['title' => 'Class Leader – Rogue', 'seniority' => 2],
            // ['title' => 'Class Leader – Shaman', 'seniority' => 2],
            ['title' => 'Class Leader – Warlock', 'seniority' => 2],
            ['title' => 'Class Leader – Warrior', 'seniority' => 2],
            ['title' => 'Commander', 'seniority' => 3],
            ['title' => 'Lieutenant', 'seniority' => 4],
            ['title' => 'Member', 'seniority' => 5],
            ['title' => 'Initiate', 'seniority' => 6],
            // ['title' => 'Retired Member', 'seniority' => 8],
            ['title' => 'Applicant', 'seniority' => 9]
            ['title' => 'Expelled Member', 'seniority' => 10],
        ]);
    }
}
