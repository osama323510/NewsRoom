<?php

namespace App\Models;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }
}
