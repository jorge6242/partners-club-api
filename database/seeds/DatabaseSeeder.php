<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StatusPeopleTableSeeder::class);
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(ProfessionTableSeeder::class);
        $this->call(TransactionTypesSeeder::class);
    }
}
