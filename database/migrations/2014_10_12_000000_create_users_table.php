<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();

            $table->string('membership_level')->nullable();
            $table->string('membership_no')->nullable();
            $table->string('membership_expire')->nullable();

            $table->string('contract_expire')->nullable();
            $table->string('contract_delay')->nullable();
            $table->string('contract_automatic_reactive')->nullable()->default(0);

            $table->string('estate')->nullable()->default(0);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('active')->default(1);
            $table->unsignedInteger('archive')->default(0);
            $table->string('slug')->nullable();
            $table->integer('dark_mode')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
