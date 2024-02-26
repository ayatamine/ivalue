<?php

use App\Models\Estate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estate_rater_tables', function (Blueprint $table) {
            $table->foreignIdFor(Estate::class)->cascadeOnDelete();
            $table->text('rating_ways_table_data')->nullable(); //user choose a way max 3 ways
            $table->text('choosen_tables_data')->nullable(); //user fill the choosen_table
            $table->text('value_equalizer_table_data')->nullable();
            $table->text('value_edit_table_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_rater_tables');
    }
};
