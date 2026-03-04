<?php

namespace App\Actions\Shows;

use App\Models\Show;
use Illuminate\Support\Facades\DB;

class StoreShow
{
    public function execute(array $data): Show
    {
        return DB::transaction(function () use ($data) {
            
            if (isset($data['cover_image'])) {
                $imagePath = $data['cover_image']->store('covers', 'public');
                $data['cover_image'] = $imagePath;
            }

            $show = Show::create(collect($data)->except('genre_ids')->toArray());

            if (isset($data['genre_ids'])) {
                $show->genres()->sync($data['genre_ids']);
            }

            return $show;
        });
    }
}