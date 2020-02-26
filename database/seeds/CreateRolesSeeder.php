<?php

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;

class CreateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $owner = new Role();
        // $owner->name         = 'owner';
        // $owner->display_name = 'Project Owner'; // optional
        // $owner->description  = 'User is the owner of a given project'; // optional
        // $owner->save();
        
        // $admin = new Role();
        // $admin->name         = 'admin';
        // $admin->display_name = 'User Administrator'; // optional
        // $admin->description  = 'User is allowed to manage and edit other users'; // optional
        // $admin->save();

        // $user = User::where('email','user@test.com')->first();
        // $user1 = User::where('email','user1@test.com')->first();
        // $admin = Role::where('name','admin')->first();
        // $owner = Role::where('name','owner')->first();

        
        // $user->attachRole($admin);
        // $user1->attachRole($owner);


        $createBank = new Permission();
        $createBank->name         = 'sdasdasd';
        $createBank->display_name = 'sadasdsa'; // optional
        // Allow a user to...
        $createBank->description  = 'sadsadsad'; // optional
        $createBank->save();
        dd($createBank);
        // $editBank = new Permission();
        // $editBank->name         = 'maestro-banco-editar';
        // $editBank->display_name = 'Editar Banco'; // optional
        // // Allow a user to...
        // $editBank->description  = 'editar un banco existente'; // optional
        // $editBank->save();


        // $admin->attachPermission($createBank);
        // // equivalent to $admin->perms()->sync(array($createBank->id));

        // $owner->attachPermissions(array($createBank, $editBank));
        // // equivalent to $owner->perms()->sync(array($createPost->id, $editBank->id));
    }
}
