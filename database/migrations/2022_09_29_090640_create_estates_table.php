<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->string('name_arabic')->nullable();
            $table->string('name_english')->nullable();
            $table->text('address')->nullable();
            $table->text('about')->nullable();

            $table->string('land_size')->nullable();
            $table->string('build_size')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->string('age')->nullable();

            $table->string('level')->nullable();

            $table->string('slug')->nullable();

            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('category_id')->unsigned()->index()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->bigInteger('kind_id')->unsigned()->index()->nullable();
            $table->foreign('kind_id')->references('id')->on('kinds')->onDelete('cascade');

            $table->bigInteger('city_id')->unsigned()->index()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->string('code')->nullble();
            $table->tinyInteger('active')->default(1)->nullable();
            $table->unsignedInteger('archive')->nullable();
            $table->string('qema')->nullable();
            $table->string('report_type')->default('new');
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
        Schema::dropIfExists('estates');
    }
}
