<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['id' => 1, 'nombre' => 'Novela'],
            ['id' => 2, 'nombre' => 'Fantasía'],
            ['id' => 3, 'nombre' => 'Misterio'],
            ['id' => 4, 'nombre' => 'Ciencia Ficción'],
            ['id' => 5, 'nombre' => 'Biografía'],
            ['id' => 6, 'nombre' => 'Juvenil'],
            ['id' => 7, 'nombre' => 'Thriller'],
            ['id' => 8, 'nombre' => 'Romance'],
            ['id' => 9, 'nombre' => 'Infantil'],
            ['id' => 10, 'nombre' => 'Drama histórico'],
        ]);

        DB::table('usuarios')->insert([
            [
                'id' => 1,
                'nombre' => 'Manuel',
                'email' => 'manuel@lecturacompartida.com',
                'password' => Hash::make('123456'),
                'tipo_usuario' => 'admin',
            ],
            [
                'id' => 2,
                'nombre' => 'Javier',
                'email' => 'javier@lecturacompartida.com',
                'password' => Hash::make('123456'),
                'tipo_usuario' => 'usuario',
            ],
            [
                'id' => 3,
                'nombre' => 'Rafael',
                'email' => 'rafael@lecturacompartida.com',
                'password' => Hash::make('123456'),
                'tipo_usuario' => 'usuario',
            ],
            [
                'id' => 4,
                'nombre' => 'Lucía',
                'email' => 'lucia@lecturacompartida.com',
                'password' => Hash::make('123456'),
                'tipo_usuario' => 'usuario',
            ],
        ]);

        DB::table('libros')->insert([
            [
                'id' => 1,
                'titulo' => 'Lo que encontré bajo el sofá',
                'autor' => 'Eloy Moreno',
                'descripcion' => 'Una novela contemporánea con tono emotivo y reflexivo sobre la vida, las decisiones y lo que escondemos bajo la superficie.',
                'imagen' => 'uploads/loqueencontrebajoelsofa.jpg',
                'id_categoria' => 1,
                'id_usuario' => 1,
                'estado' => 'disponible',
            ],
            [
                'id' => 2,
                'titulo' => 'Cuando el cielo se vuelva amarillo',
                'autor' => 'Nerea Pascual',
                'descripcion' => 'Historia juvenil de emociones, crecimiento personal y vínculos marcados por la sensibilidad y la esperanza.',
                'imagen' => 'uploads/cuandoelcielosevuelvaamarillo.jpg',
                'id_categoria' => 6,
                'id_usuario' => 1,
                'estado' => 'disponible',
            ],
            [
                'id' => 3,
                'titulo' => 'La profesora',
                'autor' => 'Freida McFadden',
                'descripcion' => 'Thriller psicológico lleno de tensión, secretos y giros alrededor de una profesora aparentemente intachable.',
                'imagen' => 'uploads/laprofesora.jpg',
                'id_categoria' => 7,
                'id_usuario' => 2,
                'estado' => 'disponible',
            ],
            [
                'id' => 4,
                'titulo' => 'El chico de arriba',
                'autor' => 'Marie Jenne',
                'descripcion' => 'Novela juvenil de relaciones, convivencia y sentimientos que nacen entre vecinos.',
                'imagen' => 'uploads/elchicodearriba.jpg',
                'id_categoria' => 8,
                'id_usuario' => 2,
                'estado' => 'disponible',
            ],
            [
                'id' => 5,
                'titulo' => 'La razón de estar contigo: Un nuevo viaje',
                'autor' => 'W. Bruce Cameron',
                'descripcion' => 'Relato emotivo sobre la lealtad, el cariño y el vínculo entre humanos y perros.',
                'imagen' => 'uploads/larazondeestarcontigo.jpg',
                'id_categoria' => 1,
                'id_usuario' => 3,
                'estado' => 'disponible',
            ],
            [
                'id' => 6,
                'titulo' => 'El jardín de las mariposas',
                'autor' => 'Dot Hutchison',
                'descripcion' => 'Thriller oscuro e inquietante con una historia perturbadora y una atmósfera de suspense constante.',
                'imagen' => 'uploads/eljardindelasmariposas.jpg',
                'id_categoria' => 7,
                'id_usuario' => 3,
                'estado' => 'disponible',
            ],
            [
                'id' => 7,
                'titulo' => 'La hija olvidada',
                'autor' => 'Armando Lucas Correa',
                'descripcion' => 'Drama histórico y familiar sobre memoria, pérdida e identidad a través de varias generaciones.',
                'imagen' => 'uploads/lahijaolvidada.jpg',
                'id_categoria' => 10,
                'id_usuario' => 4,
                'estado' => 'disponible',
            ],
            [
                'id' => 8,
                'titulo' => 'La casa del azúcar',
                'autor' => 'Ángeles Gil',
                'descripcion' => 'Novela ambientada en un contexto histórico con personajes marcados por la lucha, la familia y el destino.',
                'imagen' => 'uploads/lacasadelazucar.jpg',
                'id_categoria' => 10,
                'id_usuario' => 4,
                'estado' => 'disponible',
            ],
        ]);
    }
}