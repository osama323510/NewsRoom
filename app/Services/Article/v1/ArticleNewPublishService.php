<?php

namespace App\Services\Article\v1;

use App\Eloquent\ArticleRepository;
use Illuminate\Support\Facades\Gate;

class ArticleNewPublishService
{
    /**
     * Create a new class instance.
     */
    protected $repository;
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }
    public function publish($id)
    {
        $article = $this->repository->exist($id);
        if (!$article) {
            throw new \Exception('Article not found');
        }
        elseif(Gate::allows('update', $article))
            return $this->repository->publish($id);
        throw new \Exception('You are not allowed to publish this Article', 403);
    }
}
