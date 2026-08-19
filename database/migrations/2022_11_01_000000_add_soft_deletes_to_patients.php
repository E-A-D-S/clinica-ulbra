<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Soft delete: pacientes nunca sao apagados de fato (guarda legal de prontuario,
     * Resolucao CFP 001/2009). Apenas ficam "arquivados" e saem da lista ativa.
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
