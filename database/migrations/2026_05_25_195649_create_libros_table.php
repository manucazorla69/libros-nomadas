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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->string('autor', 100);
            $table->text('descripcion')->nullable();
            $table->string('imagen');
            $table->foreignId('id_categoria')->constrained('categorias')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->enum('estado', ['disponible', 'intercambiado'])->default('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
