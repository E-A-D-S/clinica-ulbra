<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->dateTime('data_hora');
            $table->string('profissional')->nullable();
            $table->text('anotacoes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atendimentos');
    }
};
