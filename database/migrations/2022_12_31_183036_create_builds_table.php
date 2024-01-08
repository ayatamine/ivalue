<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->id();

            $table->string('key')->nullable();
            $table->string('name')->nullable();
            $table->double('value')->nullable();
            $table->string('type')->nullable();

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
        Schema::dropIfExists('builds');
    }
}
