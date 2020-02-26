<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Administrador', 'slug' => 'administrador' ],
            [ 'name' => 'Gerente', 'slug' => 'gerente' ],
            [ 'name' => 'Asistente', 'slug' => 'asistente' ],
        ];
        foreach ($data as $element) {
            Role::create([
                'name' => $element['name'],
                'slug' => $element['slug'],
            ]);
        }
    }
}
