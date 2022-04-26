<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'body', 'notebook_id', 'tag_id'];

    public function notebook() : BelongsTo {
        return $this->belongsTo(Notebook::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
