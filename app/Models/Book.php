<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'genre_id',
        'started_at',
        'finished_at',
        'status',
        'summary',
        'impression',
    ];

    protected $casts = [
        'started_at' => 'date',
        'finished_at' => 'date',
        'status' => BookStatus::class,
    ];

    public function genre() : BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
