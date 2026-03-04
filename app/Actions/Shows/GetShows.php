<?php

namespace App\Actions\Shows;

use App\Models\Show;
use Illuminate\Database\Eloquent\Builder;

class GetShows
{
    public function execute(array $filters = [])
    {
        $allowedSorts = [
            'title',
            'release_date',
            'rating',
            'created_at',
        ];

        $sort = $filters['sort'] ?? 'title';
        $direction = $filters['direction'] ?? 'asc';

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'title';
        }

        return Show::query()
            ->with('genres') 
            ->when(
                $filters['status'] ?? null,
                fn ($query, $status) => $query->where('status', $status)
            )
            ->when(
                $filters['genre_ids'] ?? null,
                function (Builder $query, $genreIds) {
                    $ids = is_array($genreIds) ? $genreIds : explode(',', $genreIds);
                    return $query->whereHas('genres', function ($q) use ($ids) {
                        $q->whereIn('genres.id', $ids);
                    });
                }
            )
            ->orderBy($sort, $direction)
            ->paginate(12) 
            ->withQueryString(); 
    }
}