<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('last_name',255);
            $table->string('rif_ci',255);
            $table->string('passport',255);
            $table->string('card_number',255);
            $table->date('expiration_date');
            $table->date('birth_date');
            $table->integer('gender');
            $table->string('representante', 255);
            $table->string('picture', 255);
            $table->string('id_card_picture', 255);
            $table->string('address', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('telephone1', 255);
            $table->string('telephone2', 255);
            $table->string('phone_mobile1', 255);
            $table->string('phone_mobile2', 255);
            $table->string('primary_email', 255);
            $table->string('secondary_email', 255);
            $table->string('fax', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
