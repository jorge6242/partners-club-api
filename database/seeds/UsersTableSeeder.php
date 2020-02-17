<?php

use App\User;
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
        $users = [
            [ 
                'name' => 'User Test ',
                'email' => 'user@test.com',
                'password' => bcrypt(123456),
            ],
            [ 
                'name' => 'User Test 1',
                'email' => 'user1@test.com',
                'password' => bcrypt(123456),
            ],
            [ 
                'name' => 'User Test 2',
                'email' => 'user2@test.com',,
                'password' => bcrypt(123456),
            ],
        ];
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
        }
    }
}
