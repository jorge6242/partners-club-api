<?php

use App\User;
use App\Role;
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
                'name' => 'Admin Test ',
                'email' => 'admin@test.com',
                'password' => '123456',
                'role' => 'administrador',
            ],
            [ 
                'name' => 'Gerente Test 1',
                'email' => 'gerente@test.com',
                'password' => '123456',
                'role' => 'gerente',
            ],
            [ 
                'name' => 'Secretaria Test 2',
                'email' => 'secretaria@test.com',
                'password' => '123456',
                'role' => 'secretaria',
            ],
        ];
        foreach ($users as $user) {
           $role = Role::where('slug',$user['role'])->first();
           $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
            $user->assignRole($role->id);
        }
    }
}
