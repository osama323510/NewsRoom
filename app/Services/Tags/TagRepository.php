<?php

namespace App\services\Tags;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function getMostUsedTags(int $limit = 5)
    {
        return Tag::withCount('articles') 
            ->orderBy('articles_count', 'desc')
            ->limit($limit)
            ->pluck('name')
            ->toArray();
    }
    
}
