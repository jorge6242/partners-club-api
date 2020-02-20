<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Venezuela' ],
            [ 'description' => 'Colombia' ],
        ];
        foreach ($data as $element) {
            Country::create([
                'description' => $element['description'],
            ]);
        }
    }
}
