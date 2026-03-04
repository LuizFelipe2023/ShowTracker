<?php

namespace App\Actions\Shows;

use App\Models\Show;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateShow
{
    public function execute(Show $show, array $data): Show
    {
        return DB::transaction(function () use ($show, $data) {
            
            if (isset($data['cover_image']) && $data['cover_image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($show->cover_image) {
                    Storage::disk('public')->delete($show->cover_image);
                }

                $imagePath = $data['cover_image']->store('covers', 'public');
                $data['cover_image'] = $imagePath;
            }

            if (isset($data['genre_ids'])) {
                $show->genres()->sync($data['genre_ids']);
            }

            $show->update(collect($data)->except('genre_ids')->toArray());

            return $show->fresh();
        });
    }
}