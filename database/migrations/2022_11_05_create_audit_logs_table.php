<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Trilha de auditoria: registra quem fez o que, em qual paciente, quando e de onde.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_role')->nullable();
            $table->string('action');                       // ex.: paciente.cadastrar
            $table->string('subject_type')->nullable();     // ex.: Patient
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('user_email');
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
