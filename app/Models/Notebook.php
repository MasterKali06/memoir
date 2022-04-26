<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Notebook extends Model
{
    use HasFactory;

    protected $table = 'notebooks';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
