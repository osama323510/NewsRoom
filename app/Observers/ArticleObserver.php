<?php

namespace App\Observers;

use App\Jobs\SendNewArticleNotification;
use App\Jobs\test;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        Cache::tags('articles_data')->flush();
    }

    /**
     * Handle the Article "updated" event.
     */

    public function updated(Article $article): void
{
    Cache::tags('articles_data')->flush();

    $currentStatus = $article->status instanceof \BackedEnum ? $article->status->value : $article->status;
    $originalStatus = $article->getOriginal('status') instanceof \BackedEnum ? $article->getOriginal('status')->value : $article->getOriginal('status');

    Log::info('Observer Values -> Current: ' . $currentStatus . ' | Original: ' . $originalStatus);

    
    if ($currentStatus === 'published' && $originalStatus !== 'published') {
        Log::info('Success! Condition passed, dispatching job'.$article->user->name);

        SendNewArticleNotification::dispatch($article->user, $article->title);

    } else {
        Log::warning('Condition failed because the article was already published before this update.');
    }
            

}


    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        Cache::tags('articles_data')->flush();
        
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
