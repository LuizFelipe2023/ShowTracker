<?php

namespace App\Actions\Shows;

use App\Models\Show;
use Illuminate\Support\Facades\Storage;

class DeleteShow
{
    public function execute(Show $show)
    {
        if ($show->cover_image) {
            Storage::disk('public')->delete($show->cover_image);
        }

        return $show->deleteOrFail();
    }
}