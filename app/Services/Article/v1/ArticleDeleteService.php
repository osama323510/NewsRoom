<?php

namespace App\Services\Article\v1;

use App\Eloquent\ArticleRepository;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleDeleteService
{
    /**
     * Create a new class instance.
     */
    protected $repository;
    public function __construct(ArticleRepository $repository)
    {
        $this->repository=$repository;
    }

    public function delete($id)
    {
        $aricle=$this->repository->exist($id);
        if(!$aricle)
            throw new \Exception('Article not found', 404);
        if(Gate::allows('delete', $aricle))
            return $this->repository->delete($id);
        throw new \Exception('You are not allowed to delete Article', 403);
    }
}
