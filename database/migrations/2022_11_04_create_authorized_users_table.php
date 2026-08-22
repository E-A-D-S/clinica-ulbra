<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// E-mails pre-autorizados a acessar o painel, com o papel de cada um.
// Quando a pessoa entra com o Google nesse e-mail, recebe o papel definido aqui.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorized_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('role'); // dono, tutor, estagiario
            $table->unsignedBigInteger('invited_by')->nullable(); // quem convidou
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorized_users');
    }
};
