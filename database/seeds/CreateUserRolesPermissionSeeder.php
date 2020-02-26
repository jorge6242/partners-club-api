<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Permission;
class CreateUserRolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('email','admin@test.com')->first();
        $gerente = User::where('email','gerente@test.com')->first();
        $role_admin = Role::where('name','administrador')->first();
        $role_gerente = Role::where('name','gerente')->first();

        // $admin->attachRole($role_admin);
        // $gerente->attachRole($role_gerente);

        $bancoVer = Permission::where('name','maestro-banco-ver')->first();
        $bancoCrear = Permission::where('name','maestro-banco-crear')->first();
        $bancoEditar = Permission::where('name','maestro-banco-editar')->first();
        $bancoBorrar = Permission::where('name','maestro-banco-borrar')->first();

        $deporteVer = Permission::where('name','maestro-deporte-ver')->first();
        $deporteCrear = Permission::where('name','maestro-deporte-crear')->first();
        $deporteEditar = Permission::where('name','maestro-deporte-editar')->first();
        $deporteBorrar = Permission::where('name','maestro-deporte-borrar')->first();

        $paisVer = Permission::where('name','maestro-pais-ver')->first();
        $paisCrear = Permission::where('name','maestro-pais-crear')->first();
        $paisEditar = Permission::where('name','maestro-pais-editar')->first();
        $paisBorrar = Permission::where('name','maestro-pais-borrar')->first();


        $this->attachPermission($role_admin, array($bancoVer, $bancoCrear, $bancoEditar, $bancoBorrar, $paisVer, $paisCrear, $paisEditar, $paisBorrar, $deporteVer, $deporteCrear, $deporteEditar, $deporteBorrar));
        $this->attachPermission($role_gerente, array($bancoVer, $paisVer, $deporteVer, $deporteCrear));

    }

    public function attachPermission($role, $data) {
        foreach ($data as $element) {
            $role->attachPermission($element);
        }
    }
}
