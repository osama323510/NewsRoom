<?php

namespace App\Services\Article\v1;

use App\Eloquent\ArticleRepository;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;

class ArticleShowService
{
    /**
     * Create a new class instance.
     */
    protected $repository;
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find($id)
    {   
        $Article=$this->repository->exist($id);
        if(!$Article)
            throw new \Exception('Article not found', 404);
        elseif(Gate::allows('view', $Article))
            return $this->repository->find($id);
        throw new \Exception('You are not allowed to see this Article', 403);
    }
}
