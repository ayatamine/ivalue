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
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->mediumText('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('whatstapp_number')->nullable();
            $table->string('website_link')->nullable();
            $table->string('address')->nullable();
            $table->string('currency')->nullable();
            $table->string('commercial_register_number')->nullable();
            $table->string('commercial_register_photo')->nullable();
            $table->date('commercial_register_end_at')->nullable();
            $table->string('tax_number')->nullable()->comment('الرقم الضريبي');
            $table->string('tax_certificate_image')->nullable();
            $table->string('license_number')->nullable()->comment('رقم رخصة الهيئة');
            $table->string('license_image')->nullable()->comment('صورة رخصة الهيئة');
            $table->string('evaluation_branch')->nullable()->comment('فرع التقييم');
            $table->date('evaluation_end_date')->nullable()->comment('تاريخ الانتهاء');
            $table->timestamps();
            $table->json('data')->nullable();
            $table->string('domain')->unique()->nullable();
            $table->string('database')->unique()->nullable();
            $table->string('database_username')->nullable();
            $table->string('database_password')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->nullable()->references('id')->on('users')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};
