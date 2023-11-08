<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_directions', function (Blueprint $table) {
            $table->id();
            $table->string('direction')->nullable();
            $table->string('limit')->nullable();
            $table->string('length')->nullable();
            $table->bigInteger('estate_id')->unsigned()->index()->nullable();
            $table->foreign('estate_id')->references('id')->on('estates')->onDelete('cascade');
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
        Schema::dropIfExists('estate_directions');
    }
}
