<?php

namespace Database\Seeders;

use App\Models\Show;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class ShowSeeder extends Seeder
{
    public function run(): void
    {
        $generos = Genre::all();

        $shows = [
            [
                'title' => 'Breaking Bad',
                'description' => 'Um professor de química se torna um mestre do crime.',
                'release_date' => '2008-01-20',
                'rating' => 9.5,
                'status' => 'finished',
                'cover_image' => 'https://via.placeholder.com/300x450?text=Breaking+Bad',
            ],
            [
                'title' => 'The Bear',
                'description' => 'Um jovem chef de alta gastronomia tenta salvar a lanchonete da família.',
                'release_date' => '2022-06-23',
                'rating' => 8.6,
                'status' => 'watching',
                'cover_image' => 'https://via.placeholder.com/300x450?text=The+Bear',
            ],
            [
                'title' => 'Dark',
                'description' => 'O desaparecimento de crianças expõe segredos de quatro famílias.',
                'release_date' => '2017-12-01',
                'rating' => 8.7,
                'status' => 'finished',
                'cover_image' => 'https://via.placeholder.com/300x450?text=Dark',
            ],
        ];

        foreach ($shows as $showData) {
            $show = Show::create($showData);
            
            if ($generos->count() > 0) {
                $show->genres()->attach(
                    $generos->random(rand(1, min(3, $generos->count())))->pluck('id')->toArray()
                );
            }
        }
    }
}