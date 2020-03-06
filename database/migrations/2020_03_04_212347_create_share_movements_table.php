<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_movements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('share_number',255);
            $table->string('description',255);
            $table->string('rate', 255);
            $table->string('sale_price', 255);
            $table->bigInteger('procesed');
            $table->bigInteger('transaction_type_id');
            $table->bigInteger('people_id');
            $table->bigInteger('id_titular_persona');
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
        Schema::dropIfExists('share_movements');
    }
}