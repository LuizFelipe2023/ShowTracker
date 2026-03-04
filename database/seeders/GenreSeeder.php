<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Ação',
            'Aventura',
            'Animação',
            'Comédia',
            'Crime',
            'Documentário',
            'Drama',
            'Fantasia',
            'Ficção Científica',
            'Horror',
            'Mistério',
            'Romance',
            'Suspense',
            'Thriller',
            'Guerra',
            'Anime',
            'Reality Show'
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['name' => $genre]);
        }
    }
}