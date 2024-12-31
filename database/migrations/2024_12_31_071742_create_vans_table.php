<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVansTable extends Migration
{
    public function up()
    {
        Schema::create('vans', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('model');
            $table->integer('capacity');
            $table->decimal('rental_rate', 10, 2);
            $table->string('license_plate');
            $table->boolean('availability')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vans');
    }
};