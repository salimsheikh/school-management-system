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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('fee_head_id')->constrained('fee_heads')->onDelete('cascade');
            $table->string('month01')->nullable();
            $table->string('month02')->nullable();
            $table->string('month03')->nullable();
            $table->string('month04')->nullable();
            $table->string('month05')->nullable();
            $table->string('month06')->nullable();
            $table->string('month07')->nullable();
            $table->string('month08')->nullable();
            $table->string('month09')->nullable();
            $table->string('month10')->nullable();
            $table->string('month11')->nullable();
            $table->string('month12')->nullable();
            //$table->string('start_month')->nullable();
            $table->timestamps();

            // Add unique constraint on class_id, academic_year_id, and fee_head_id
            //$table->unique(['class_id', 'academic_year_id', 'fee_head_id'], 'unique_fee_structure');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
