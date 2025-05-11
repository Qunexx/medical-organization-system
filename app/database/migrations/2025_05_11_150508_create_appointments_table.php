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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->timestamp('appointment_date');
            $table->tinyInteger('status');
            $table->string('patient_name');
            $table->string('patient_phone');
            $table->string('patient_email');
            $table->foreignId('specialization_id')->constrained('specializations');
            $table->text('patient_comment')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->text('conclusion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
