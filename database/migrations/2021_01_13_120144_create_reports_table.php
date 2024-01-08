<?php

use App\Models\Estate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('flat')->nullable();
            $table->string('floor')->nullable();
            $table->string('name')->nullable();
            $table->string('price');
            $table->string('color');
            $table->string('kind');
            $table->string('date');
            $table->string('slug');
            $table->foreignIdFor(Estate::class)->nullable();
            // $table->unsignedInteger('estate_id');
            // $table->foreign('estate_id')->nullable()->references('id')->on('estates')->cascadeOnDelete();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('reports');
    }
}
