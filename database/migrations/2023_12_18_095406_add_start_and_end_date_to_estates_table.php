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
            // $table->dropColumn('perviewer_date');
            // $table->dropColumn('reviewer_date');
            // $table->dropColumn('rater_date');
            // $table->dropColumn('approver_date');
            $table->date('process_start_date')->nullable()->after('rater_reason')->comment('تاريخ بداية الطلب');
            $table->date('process_end_date')->nullable()->after('process_start_date')->comment('تاريخ انتهاء الطلب');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estates', function (Blueprint $table) {
            // $table->date('perviewer_date')->nullable();
            // $table->date('reviewer_date')->nullable();
            // $table->date('rater_date')->nullable();
            // $table->date('approver_date')->nullable();
            $table->dropColumn('process_start_date');
            $table->dropColumn('process_end_date');
        });
    }
};
