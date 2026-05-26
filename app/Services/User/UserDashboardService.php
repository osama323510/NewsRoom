<?php

namespace App\services\User;

use App\contract\ArticleRepositoryInterface;
use App\Jobs\CacheMostUsedTagsJob;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class UserDashboardService
{
    /**
     * Create a new class instance.
     */
    protected $repository;
    public function __construct( 
    UserDashboardServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function dashboard()
{
    
    $mostUsedTags = Cache::rememberForever('dashboard_most_used_tags', function () {
    return app(\App\services\Tags\TagRepository::class)->getMostUsedTags(5);
});

    $cacheKey = 'dashboard:general_stats';
    $tags = ['dashboard_stats', 'articles_data'];
    $generalStats = Cache::lock('lock:dashboard_stats', 10)->block(5, function () use ($tags, $cacheKey) {
        return Cache::tags($tags)->remember($cacheKey, now()->addHours(2), function () {
            
        return $this->repository->getDashboardStats();

        });
    });
    return array_merge($generalStats, [
            'most_used_tags' => $mostUsedTags
        ]);
}
}
