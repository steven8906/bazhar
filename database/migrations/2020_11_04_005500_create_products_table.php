<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_provider')->unsigned();
            $table->bigInteger('id_tax')->unsigned();
            $table->bigInteger('id_business')->unsigned();
            $table->bigInteger('id_presentation')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->enum('currency',['USD','COP']);
            $table->decimal('priceShop',10,2);            
            $table->decimal('priceSell',10,2);            
            $table->tinyInteger('isVariable')->default(0);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table){
            $table->foreign('id_provider')
                ->references('id')
                ->on('providers')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_tax')
                ->references('id')
                ->on('taxes')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_business')
                ->references('id')
                ->on('business')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_presentation')
                ->references('id')
                ->on('presentations')
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
        Schema::dropIfExists('products');
    }
}
