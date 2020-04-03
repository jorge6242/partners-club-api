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
