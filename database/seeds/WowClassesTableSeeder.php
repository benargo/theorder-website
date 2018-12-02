<?php

use Illuminate\Database\Seeder;

class WowClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wow_classes')->insert([
            ['id' => 1, 'mask' => 1, 'powerType' => 'rage', 'name' => 'warrior', 'is_recruiting' => true],
            ['id' => 2, 'mask' => 2, 'powerType' => 'mana', 'name' => 'paladin', 'is_recruiting' => true],
            ['id' => 3, 'mask' => 4, 'powerType' => 'mana', 'name' => 'hunter', 'is_recruiting' => true],
            ['id' => 4, 'mask' => 8, 'powerType' => 'energy', 'name' => 'rogue', 'is_recruiting' => true],
            ['id' => 5, 'mask' => 16, 'powerType' => 'mana', 'name' => 'priest', 'is_recruiting' => true],
            ['id' => 8, 'mask' => 128, 'powerType' => 'mana', 'name' => 'mage', 'is_recruiting' => true],
            ['id' => 9, 'mask' => 256, 'powerType' => 'mana', 'name' => 'warlock', 'is_recruiting' => true],
            ['id' => 11, 'mask' => 1024, 'powerType' => 'mana', 'name' => 'druid', 'is_recruiting' => true],
        ]);
    }
}
