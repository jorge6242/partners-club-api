<?php

use Illuminate\Database\Seeder;

use App\Permission;
class PermissionsSeeder extends Seeder
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
                'name' => 'maestro-banco-ver', 
                'display_name' => 'Ver Banco', 
                'description' => 'Ver Banco' 
            ],
            [ 
                'name' => 'maestro-banco-crear', 
                'display_name' => 'Crear Banco', 
                'description' => 'Crear Banco' 
            ],
            [ 
                'name' => 'maestro-banco-editar', 
                'display_name' => 'Editar Banco', 
                'description' => 'Editar Banco' 
            ],
            [ 
                'name' => 'maestro-banco-borrar', 
                'display_name' => 'Borrar Banco', 
                'description' => 'Borrar Banco' 
            ],

            //PAIS
            [ 
                'name' => 'maestro-pais-ver', 
                'display_name' => 'Ver Pais', 
                'description' => 'Ver Pais' 
            ],
            [ 
                'name' => 'maestro-pais-crear', 
                'display_name' => 'Crear Pais', 
                'description' => 'Crear Pais' 
            ],
            [ 
                'name' => 'maestro-pais-editar', 
                'display_name' => 'Editar Pais', 
                'description' => 'Editar Pais' 
            ],
            [ 
                'name' => 'maestro-pais-borrar', 
                'display_name' => 'Borrar Pais', 
                'description' => 'Borrar Pais' 
            ],

            //Deportes
            [ 
                'name' => 'maestro-deporte-ver', 
                'display_name' => 'Ver Deporte', 
                'description' => 'Ver Deporte' 
            ],
            [ 
                'name' => 'maestro-deporte-crear', 
                'display_name' => 'Crear Deporte', 
                'description' => 'Crear Deporte' 
            ],
            [ 
                'name' => 'maestro-deporte-editar', 
                'display_name' => 'Editar Deporte', 
                'description' => 'Editar Deporte' 
            ],
            [ 
                'name' => 'maestro-deporte-borrar', 
                'display_name' => 'Borrar Deporte', 
                'description' => 'Borrar Deporte' 
            ],
        ];
        foreach ($data as $element) {
            Permission::create([
                'name' => $element['name'],
                'display_name' => $element['display_name'],
                'description' => $element['description'],
            ]);
        }
    }
}
