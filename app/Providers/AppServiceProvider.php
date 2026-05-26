<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\contract\ArticleRepositoryInterface;
use App\contract\UserRepositoryInterface;
use App\Eloquent\ArticleRepository;
use App\Eloquent\UserRepository;
use App\Services\NotificationHandler\Notify;
use App\Services\Notification\DatabaseNotificationDispatcher;
use App\Services\Notification\EmailNotificationDispatcher;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);




        $this->app->bind(Notify::class, function ($app) {
            return new Notify(
                $app->make(DatabaseNotificationDispatcher::class),
                $app->make(EmailNotificationDispatcher::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}


