<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_name',
        'image_path',
        'body'
    ];

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
