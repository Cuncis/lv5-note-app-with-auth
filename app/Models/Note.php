<?php

namespace App\Models;

use App\Enums\NoteCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'category', 'is_pinned', 'user_id'];

    protected $casts = [
        'is_pinned' => 'boolean',
        'category'  => NoteCategory::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeUnpinned($query)
    {
        return $query->where('is_pinned', false);
    }
}
