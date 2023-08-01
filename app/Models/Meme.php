<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meme extends Model
{
    use HasFactory;

    protected $with = ['user'];

    protected $guarded = [
        'id'
    ];

    public function scopeFilters($query, array|null $filters): void
    {
        $query->when($filters['username'] ?? false, fn ($query, $username) => $query->whereHas('username', $username));
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
