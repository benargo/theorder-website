<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockAddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'user_id'                   => 1922840,
            'name'                      => 'Stock Addon',
            'secret'                    => Str::random(40),
            'redirect'                  => 'http://localhost:9000/',
            'personal_access_client'    => 0,
            'password_client'           => 0,
            'revoked'                   => 0,
            'created_at'                => now(),
            'updated_at'                => now(),
        ]);
    }
}
