<?php

use App\Role;
use App\MenuItem;
use App\MenuItemRole;
use Illuminate\Database\Seeder;

class MenuItemRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [ 
            ['menuItem' => 'inicio', 'role' => ['administrador', 'gerente'] ],
            ['menuItem' => 'socios', 'role' => ['administrador', 'gerente'] ],
            ['menuItem' => 'acciones', 'role' => ['administrador'],
            ['menuItem' => 'mantenimiento', 'role' => ['administrador'],
            ['menuItem' => 'banco', 'role' => ['administrador'],
            ['menuItem' => 'profesion', 'role' => ['administrador'],
            ['menuItem' => 'acceso', 'role' => ['administrador'],
            ['menuItem' => 'control-de-acceso', 'role' => ['administrador'],
            ['menuItem' => 'acceso-reportes', 'role' => ['administrador'],
            ['menuItem' => 'reporte-control-de-acceso', 'role' => ['administrador'],
        ];
        foreach ($data as $key => $value) {
            $menuItem = MenuItem::where('slug', $value['menuItem'])->first();
            foreach ($variable as $key => $value) {
                $admin = Role::where('slug', $value['role'])->first();
                MenuItemRole::create([
                    'role_id' => $admin->id,
                    'menu_item_id' => $menuItem->id,
                ]);
            }
        }



        $admin = Role::where('slug', 'gerente')->first();
        $menuItem = MenuItem::where('slug', 'socios')->first();
        MenuItemRole::create([
            'role_id' => $admin->id,
            'menu_item_id' => $menuItem->id,
        ]);

        // $menuItems = MenuItem::all();
        // foreach ($menuItems as $key => $value) {
        //     MenuItemRole::create([
        //         'role_id' => $admin->id,
        //         'menu_item_id' => $value->id,
        //     ]);
        // }
    }
}
