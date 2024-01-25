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
            $table->unsignedBigInteger('previewer_id')->after('updated_at')->nullable();
            $table->unsignedBigInteger('value_approver_id')->after('approver_id')->nullable();
            $table->integer('value_approver')->after('approver')->nullable();
            $table->unsignedBigInteger('value_approver_reason')->after('previewer_reason')->nullable();
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
            $table->dropColumn('previewer_id');
            $table->dropColumn('value_approver_id');
            $table->dropColumn('value_approver');
            $table->dropColumn('value_approver_reason');
        });
    }
};
