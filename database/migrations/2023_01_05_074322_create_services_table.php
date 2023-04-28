<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('name');
            $table->foreignId('services_category_id');
            $table->text('description');
            $table->text('images');
            $table->integer('price_value');
            $table->foreignId('currency_id');
            $table->foreignId('price_unit_id')->nullable();
            $table->foreignId('sale_tag_id')->nullable();
            $table->foreignId('country_id')->nullable()->references('id')->on('places');
            $table->foreignId('city_id')->nullable()->references('id')->on('places');
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
        Schema::dropIfExists('services');
    }
}
