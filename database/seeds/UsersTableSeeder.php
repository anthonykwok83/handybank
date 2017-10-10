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
        // internal represent to Bank
        DB::table('users')->insert([
            'name' => 'Bank',
            'email' => 'bank@gmail.com',
            'password' => bcrypt('secret'),
            'is_bank_owner' => true,
        ]);


        // Normal user to present 1-5 API
        DB::table('users')->insert([
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('secret'),
        ]);


        // Normal user to present 6 API for transfer money from different user
        DB::table('users')->insert([
            'name' => 'User 2',
            'email' => 'user 2@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
