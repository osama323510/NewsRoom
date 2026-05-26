<?php

namespace App\Eloquent;
use App\Models\Article;
use Illuminate\Support\Collection;
use App\contract\ArticleRepositoryInterface;
use Carbon\Carbon;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function __construct()
    {
        
    }

    public function allPublished(): Collection
    {
        return Article::where('status', 'published')
        ->with('user') 
        ->withCount('comments') 
        ->with('tags')
        ->get();
    }

    public function find(int $id): ?Article
    {
        return Article::where('id', $id)
        ->with('user') 
        ->with('comments') 
        ->first();
    }
    

    public function create($data)
    {
        return Article::create($data);
    }

    public function update($id, array $data): Article
    {
        $article = $this->find($id);
        $article->update($data);
        return $article;
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }
    
    public function publish($id)
    {
        $article = Article::find($id);
        $article->status = 'published';
        $article->save();
        return $article;
    }

    public function exist($id)
    {
        return Article::find($id);
    }

    public function archive($days)
    {
        $targetDate = Carbon::now()->subDays($days);
        return Article::where('status','draft')
            ->where('created_at', '<', $targetDate)
            ->update(['status' => 'archived']);

    }


    

    
}

