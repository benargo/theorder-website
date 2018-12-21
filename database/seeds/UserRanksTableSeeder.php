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
            // ['title' => 'Grand Master', 'seniority' => 0, 'kudos_per_day' => DB::raw('null')],
            ['title' => 'Inner Circle', 'seniority' => 1, 'kudos_per_day' => DB::raw('null')],
            ['title' => 'Class Leader – Druid', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Hunter', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Mage', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Paladin', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Priest', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Rogue', 'seniority' => 2, 'kudos_per_day' => 25],
            // ['title' => 'Class Leader – Shaman', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Warlock', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Class Leader – Warrior', 'seniority' => 2, 'kudos_per_day' => 25],
            ['title' => 'Commander', 'seniority' => 3, 'kudos_per_day' => 25],
            ['title' => 'Lieutenant', 'seniority' => 4, 'kudos_per_day' => 20],
            ['title' => 'Member', 'seniority' => 5, 'kudos_per_day' => 10],
            ['title' => 'Initiate', 'seniority' => 6, 'kudos_per_day' => 5],
            // ['title' => 'Retired Member', 'seniority' => 8, 'kudos_per_day' => 10],
            ['title' => 'Applicant', 'seniority' => 9, 'kudos_per_day' => 1],
            ['title' => 'Expelled Member', 'seniority' => 10, 'kudos_per_day' => 0],
        ]);
    }
}
