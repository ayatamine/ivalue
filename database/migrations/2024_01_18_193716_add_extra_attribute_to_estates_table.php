<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->string('responsible_phone')->nullable();
            $table->unsignedInteger('floor')->nullable();
            $table->string('duration')->nullable();
            $table->string('duration_start')->nullable();
            $table->string('duration_end')->nullable();
            $table->string('evaluation_date')->nullable();
            $table->string('site_link')->nullable();
            $table->boolean('revised_by_enter')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            $table->dropColumn('responsible_phone');
            $table->dropColumn('floor');
            $table->dropColumn('duration');
            $table->dropColumn('duration_start');
            $table->dropColumn('duration_end');
            $table->dropColumn('evaluation_date');
            $table->dropColumn('site_link');
            $table->dropColumn('revised_by_enter');
        });
    }
};
