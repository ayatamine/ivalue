<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionsToOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->string('title_en')->nullable();
            $table->string('mobile')->nullable();
            $table->string('website')->nullable();
            $table->text('about')->nullable();
            $table->text('address')->nullable();

            $table->string('commercial_number')->nullable();
            $table->timestamp('commercial_date')->nullable();

            $table->string('license_number')->nullable();
            $table->timestamp('license_date')->nullable();
//            files
            $table->string('image_commercial')->nullable();
            $table->string('image_license')->nullable();
            $table->string('stamp')->nullable();
            $table->string('logo')->nullable();
            $table->string('header')->nullable();
            $table->string('footer')->nullable();
            $table->string('background')->nullable();
            $table->string('cover')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            //
        });
    }
}
