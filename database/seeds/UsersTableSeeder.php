<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Bank',
            'email' => 'bank@gmail.com',
            'password' => bcrypt('secret'),
            'is_bank_owner' => true,
        ])->accounts()->create([
            'balance' => 0
        ]);

        User::create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('secret'),
        ])->accounts()->createMany([
            ['balance' => 20000],
            ['balance' => 30000],
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('secret'),
        ])->accounts()->create([
            'balance' => 20000
        ]);


    }
}
