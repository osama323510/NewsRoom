<?php

namespace App\Models;
use App\Models\Attachment;
use App\Models\User;
use App\Models\Comment;
use App\Models\Tag;
use App\Observers\ArticleObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
#[ObservedBy([ArticleObserver::class])]
class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title','content','status','user_id'];

    protected $casts = [
    'status' => \App\Enums\ArticleStatus::class,
];






    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }



    protected function readingTime(): Attribute
{
    return Attribute::make(
        get: function () {
            $wordsPerMinute = 200;
            $wordCount = str_word_count(strip_tags($this->content));
            $minutes = ceil($wordCount / $wordsPerMinute);
            return $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes');
        }
    );
}
}
