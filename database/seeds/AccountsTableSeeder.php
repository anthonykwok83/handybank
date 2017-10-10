<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'user_id' => 1,
            'balance' => 0
        ]);

        DB::table('accounts')->insert([
            'user_id' => 2,
            'balance' => 20000
        ]);

        DB::table('accounts')->insert([
            'user_id' => 3,
            'balance' => 20000
        ]);

    }
}
