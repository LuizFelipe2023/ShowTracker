<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'release_date', 'rating', 'status', 'cover_image'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
