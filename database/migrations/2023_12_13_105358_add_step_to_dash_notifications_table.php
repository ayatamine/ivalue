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
        Schema::table('dash_notifications', function (Blueprint $table) {
            //indicate the current step in the path
            $table->string('current_step')->after('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dash_notifications', function (Blueprint $table) {
            $table->dropColumn('current_step');
        });
    }
};
