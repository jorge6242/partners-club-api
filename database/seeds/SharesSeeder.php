<?php

use App\Share;
use Illuminate\Database\Seeder;

class SharesSeeder extends Seeder
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
                'share_number' => '120610',
                'father_share_id' => 0,
                'status' => 1,
                'payment_method_id' => 2,
                'id_persona' => 1,
                'id_titular_persona' => 5,
                'id_factura_persona' => 7,
                'id_fiador_persona' => 6
            ],
            [ 
                'share_number' => '120611',
                'father_share_id' => 1,
                'status' => 1,
                'payment_method_id' => 1,
                'id_persona' => 1,
                'id_titular_persona' => 5,
                'id_factura_persona' => 2,
                'id_fiador_persona' => 6
            ],
            [ 
                'share_number' => '120612',
                'father_share_id' => 1,
                'status' => 1,
                'payment_method_id' => 2,
                'id_persona' => 1,
                'id_titular_persona' => 5,
                'id_factura_persona' => 8,
                'id_fiador_persona' => 6
            ],
        ];
        foreach ($data as $element) {
            Share::create([
                'share_number' => $element['share_number'],
                'father_share_id' => $element['father_share_id'],
                'status' => $element['status'],
                'payment_method_id' => $element['payment_method_id'],
                'id_persona' => $element['id_persona'],
                'id_titular_persona' => $element['id_titular_persona'],
                'id_factura_persona' => $element['id_factura_persona'],
                'id_fiador_persona' => $element['id_fiador_persona'],
            ]);
        }
    }
}
