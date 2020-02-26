<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Update Bank', 'slug' => 'get-bank' ],
            [ 'name' => 'Create Bank', 'slug' => 'create-bank'  ],
            [ 'name' => 'Delete Bank', 'slug' => 'update-bank'  ],
            [ 'name' => 'Delete Bank', 'slug' => 'delete-bank'  ],
        ];
        foreach ($data as $element) {
            Permission::create([
                'name' => $element['name'],
                'slug' => $element['slug'],
            ]);
        }
    }
}
