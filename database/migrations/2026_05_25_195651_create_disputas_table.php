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
        Schema::create('disputas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_solicitud')->unique()->constrained('solicitudes')->cascadeOnDelete();
            $table->foreignId('id_usuario_reporta')->constrained('usuarios')->cascadeOnDelete();
            $table->text('motivo');
            $table->enum('estado', ['pendiente', 'resuelta'])->default('pendiente');
            $table->text('respuesta_admin')->nullable();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputas');
    }
};
