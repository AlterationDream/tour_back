<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('name');
            $table->string('categories');
            $table->string('length')->nullable();
            $table->string('short_description');
            $table->string('duration')->nullable();
            $table->string('starting')->nullable();
            $table->string('schedule')->nullable();
            $table->string('pricing')->nullable();
            $table->string('video')->nullable();
            $table->string('program', 4000);
            $table->string('additional', 4000);
            $table->string('booking', 4000);
            $table->string('image');
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
        Schema::dropIfExists('tours');
    }
}
