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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_libro')->constrained('libros')->cascadeOnDelete();
            $table->foreignId('id_libro_ofrecido')->constrained('libros')->cascadeOnDelete();
            $table->foreignId('id_solicitante')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('id_propietario')->constrained('usuarios')->cascadeOnDelete();
            $table->text('mensaje');
            $table->enum('estado', ['pendiente', 'aceptada', 'rechazada'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
