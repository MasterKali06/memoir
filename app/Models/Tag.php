<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class);
    }
}
