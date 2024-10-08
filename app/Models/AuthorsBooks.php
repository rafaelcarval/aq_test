<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class AuthorsBooks extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'books_id',
        'authors_id',
    ];

    public function authors(): BelongsTo
    {
        return $this->belongsTo(Authors::class);
    }

    public function books(): BelongsTo
    {
        return $this->belongsTo(Books::class);
    }

    public function authorsMany(): hasHasMany
    {
        return $this->hasHasMany(Authors::class);
    }

    public function booksOne(): HasOne
    {
        return $this->HasOne(Books::class);
    }
}
