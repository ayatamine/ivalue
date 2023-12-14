<?php

use App\Models\Estate;
use App\Models\User;
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
        Schema::create('order_processing_notes', function (Blueprint $table) {
            $table->id();
            $table->enum('path_type',['public','private','short','fast'])->default('public'); //مسار عام وخاص
            $table->unsignedInteger('step_number');//steps from documentation القيمة الذكية
            $table->foreignIdFor(Estate::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('reason')->nullable()->comment('accept/cancel/note'); //reject
            $table->mediumText('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_processing_notes');
    }
};
