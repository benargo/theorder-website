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
            // ['title' => 'Grand Master', 'seniority' => 0, 'kudos_per_day' => DB::raw('null'), 'discord_role' => 470584127910051842],
            ['title' => 'Inner Circle', 'seniority' => 1, 'kudos_per_day' => DB::raw('null'), 'discord_role' => 470584127910051842],
            ['title' => 'Class Leader – Druid', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Hunter', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Mage', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Paladin', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Priest', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Rogue', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            // ['title' => 'Class Leader – Shaman', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Warlock', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Class Leader – Warrior', 'seniority' => 2, 'kudos_per_day' => 25, 'discord_role' => 492290743252156420],
            ['title' => 'Raid Leader', 'seniority' => 3, 'kudos_per_day' => 25, 'discord_role' => 492290510900428800],
            ['title' => 'Commander', 'seniority' => 4, 'kudos_per_day' => 25, 'discord_role' => 471188686042562560],
            ['title' => 'Lieutenant', 'seniority' => 5, 'kudos_per_day' => 20, 'discord_role' => 492292004311597056],
            ['title' => 'Member', 'seniority' => 6, 'kudos_per_day' => 10, 'discord_role' => 471188881648254988],
            ['title' => 'Initiate', 'seniority' => 7, 'kudos_per_day' => 5, 'discord_role' => 471273928007090187],
            // ['title' => 'Retired Member', 'seniority' => 8, 'kudos_per_day' => 10, 'discord_role' => 558047571822510082],
            ['title' => 'Applicant', 'seniority' => 9, 'kudos_per_day' => 1, 'discord_role' => 558047177646014485],
            ['title' => 'Expelled Member', 'seniority' => 10, 'kudos_per_day' => 0, 'discord_role' => DB::raw('null')],
        ]);
    }
}
