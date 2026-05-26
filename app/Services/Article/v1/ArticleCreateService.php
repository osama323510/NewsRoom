<?php

namespace App\Services\Article\v1;

use App\Eloquent\ArticleRepository;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class ArticleCreateService
{
    /**
     * Create a new class instance.
     */
    protected $repository;
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($data)
    {
        $data['user_id']=Auth::user()->id;
        if(Gate::allows('create', Article::class))
            return $this->repository->create($data);
        throw new \Exception('You are not allowed to create Article', 403);
    }
}
