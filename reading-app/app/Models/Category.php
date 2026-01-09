<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function books() : BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
