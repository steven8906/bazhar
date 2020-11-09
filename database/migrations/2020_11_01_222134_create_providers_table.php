<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_business')->unsigned();
            $table->string('name');
            $table->enum('type_id', ['Cedula','NIT','Pasaporte']);
            $table->string('identification');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();
        });

        Schema::table('providers',function (Blueprint $table){
            $table->foreign('id_business')
                ->references('id')
                ->on('business')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
