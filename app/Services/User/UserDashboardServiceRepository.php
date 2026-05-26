<?php

namespace App\services\User;
use App\contract\ArticleRepositoryInterface;

class UserDashboardServiceRepository
{
    /**
     * Create a new class instance.
     */
    public  $articleRepository;
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getDashboardStats()
    {
        $articles = $this->articleRepository ->allPublished();
            $articlesCount = $articles->count();
            $commentsCount = $articles->sum('comments_count');
            $activeWriters = $articles->groupBy('user_id')
                ->map(function ($userArticles) {
                    $firstArticle = $userArticles->first();
                    return [
                        'id'             => $firstArticle->user_id,
                        'name'           => $firstArticle->user->name ?? 'Unknown', 
                        'articles_count' => $userArticles->count()
                    ];
                })
                ->sortByDesc('articles_count')
                ->take(5)
                ->values()
                ->all();
            return [
                'articles_count' => $articlesCount,
                'comments_count' => $commentsCount,
                'active_writers' => $activeWriters,
            ];

    }
}



