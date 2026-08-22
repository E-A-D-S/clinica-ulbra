<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Marca registros ficticios de demonstracao. A conta publica de demo so enxerga estes,
// nunca dados reais de clientes, equipe ou auditoria.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false);
        });
        Schema::table('authorized_users', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false);
        });
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->boolean('is_demo')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('patients', fn (Blueprint $t) => $t->dropColumn('is_demo'));
        Schema::table('authorized_users', fn (Blueprint $t) => $t->dropColumn('is_demo'));
        Schema::table('audit_logs', fn (Blueprint $t) => $t->dropColumn('is_demo'));
    }
};
