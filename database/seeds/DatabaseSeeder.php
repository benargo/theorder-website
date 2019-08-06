<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Set up the global admin users and the associated reference tables...
        $this->call(UserRanksTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WowClassesTableSeeder::class);

        // Set up the guild bank tables...
        $this->call(StockAddonSeeder::class);
    }
}
