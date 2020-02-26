<?php

use Illuminate\Database\Seeder;

use App\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 
                'name' => 'administrador', 
                'display_name' => 'Administrador', 
                'description' => 'Tiene todos los permisos' 
            ],
            [ 
                'name' => 'gerente', 
                'display_name' => 'Gerente', 
                'description' => 'Gerencia' 
            ],
            [ 
                'name' => 'secreataria', 
                'display_name' => 'Secretaria', 
                'description' => 'Secreataria' 
            ],
        ];
        foreach ($data as $element) {
            Role::create([
                'name' => $element['name'],
                'display_name' => $element['display_name'],
                'description' => $element['description'],
            ]);
        }
    }
}
