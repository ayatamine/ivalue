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
        Schema::table('options', function (Blueprint $table) {
            $table->double('offer_price')->default(0.0);
            $table->integer('price_delay')->comment('مدة عرض السعر بالايام')->defautl(1);
            $table->string('currency')->nullble();
            $table->string('work_area')->comment('نطاق العمل')->nullble();
            $table->integer('work_delay')->comment('مدةالعمل بالايام')->defautl(1);
            $table->integer('payment_partitions')->comment('عدد الدفعات')->default(0);
            $table->string('report_standards')->comment('معايير التقييم')->default('2020');
            $table->string('report_desc')->comment('وصف التقرير (ورقي ’ الكتروني')->default('ورقي');
            $table->string('report_kind')->comment('نوع التقرير')->default('تقرير مفصل');
            //give me default json with this properties previewer , rater
            $table->json('step_percentage')->comment('نسبة كل مرحلة من مراحل التقييم')->default('{"previewer":"20","rater":"20","reviewer":"20","approver":"20","value_approver":"10","submit_report":"10"}');
            $table->json('work_hour_percentage')->comment('نسبة ساعات العمل على التقرير')->default('{"previewer":"40","rater":"20","reviewer":"20","approver":"20"}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('offer_price');
            $table->dropColumn('price_delay');
            $table->dropColumn('currency');
            $table->dropColumn('work_area');
            $table->dropColumn('work_delay');
            $table->dropColumn('payment_partitions');
            $table->dropColumn('report_standards');
            $table->dropColumn('report_desc');
            $table->dropColumn('report_kind');
            $table->dropColumn('step_percentage');
            $table->dropColumn('work_hour_percentage');
        });
    }
};
