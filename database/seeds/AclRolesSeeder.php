<?php

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;

class AclRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//or create array method

// $role = new Role();
// $roleAdmin = $role->create([
//     'name' => 'Administrator',
//     'slug' => 'administrator',
//     'description' => 'manage administration privileges'
// ]);

// $role = new Role();
// $roleModerator = $role->create([
//     'name' => 'Moderator',
//     'slug' => 'moderator',
//     'description' => 'manage moderator privileges'
// ]);


// $user = User::find(1);
// $user->assignRole($roleAdmin->id);

$user = User::find(2);
$user->assignRole('administrator');





// $permission = new Permission();
// $permUser = $permission->create([ 
//     'name'        => 'otheruser',
//     'slug'        => 'create',
//     'description' => 'manage user permissions'
// ]);

// $roleAdmin = Role::find(7); // administrator
// $roleAdmin->assignPermission('maestro-banco-crear');


$user = User::find(1);
$user->getPermissions();

dd($user->getPermissions());

    }
}
