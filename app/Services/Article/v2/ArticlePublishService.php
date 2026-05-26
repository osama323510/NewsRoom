<?php

namespace App\Services\Article\v2;

use App\Eloquent\ArticleRepository;

class ArticlePublishService
{
    /**
     * Create a new class instance.
     */
    protected $repository;
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }
    public function allPublished()
    {
        return $this->repository->allPublished();
    }
}
