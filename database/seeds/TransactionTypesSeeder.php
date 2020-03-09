<?php

use App\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $data = [
                [ 
                    'description' => 'Traspaso', 
                    'rate' => 10000,
                    'apply_main' => 1,
                    'apply_extension' => 0,
                    'apply_change_user' => 0,
                ],
                [ 
                    'description' => 'Compra', 
                    'rate' => 20000,
                    'apply_main' => 0,
                    'apply_extension' => 0,
                    'apply_change_user' => 0,
                ],
                [ 
                    'description' => 'Revocacion', 
                    'rate' => 0,
                    'apply_main' => 1,
                    'apply_extension' => 1,
                    'apply_change_user' => 0,
                ],
                [ 
                    'description' => 'Carga Inicial', 
                    'rate' => 0,
                    'apply_main' => 0,
                    'apply_extension' => 0,
                    'apply_change_user' => 0,
                ],
                [ 
                    'description' => 'Cambio de Usuario', 
                    'rate' => 10000,
                    'apply_main' => 1,
                    'apply_extension' => 0,
                    'apply_change_user' => 1,
                ],
                [ 
                    'description' => 'Traspado Familiar', 
                    'rate' => 10000,
                    'apply_main' => 0,
                    'apply_extension' => 1,
                    'apply_change_user' => 0,
                ],
                [ 
                    'description' => 'Sucecion', 
                    'rate' => 0,
                    'apply_main' => 1,
                    'apply_extension' => 1,
                    'apply_change_user' => 0,
                ],
            ];
            foreach ($data as $element) {
                TransactionType::create([
                    'description' => $element['description'],
                    'rate' => $element['rate'],
                    'apply_main' => $element['apply_main'],
                    'apply_extension' => $element['apply_extension'],
                    'apply_change_user' => $element['apply_change_user'],
                ]);
            }
        }
    }
}
