<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->string('1')->nullable()->default(0);
            $table->string('2')->nullable()->default(0);
            $table->string('3')->nullable()->default(0);
            $table->string('4')->nullable()->default(0);
            $table->string('5')->nullable()->default(0);
            $table->string('6')->nullable()->default(0);
            $table->string('7')->nullable()->default(0);
            $table->string('8')->nullable()->default(0);
            $table->string('9')->nullable()->default(0);
            $table->string('10')->nullable()->default(0);
            $table->string('11')->nullable()->default(0);
            $table->string('12')->nullable()->default(0);
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
        Schema::dropIfExists('imports');
    }
}
