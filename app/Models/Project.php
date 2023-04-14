<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'user_id',
        'description'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
