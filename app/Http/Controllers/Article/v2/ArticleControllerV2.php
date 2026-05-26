<?php

namespace App\Http\Controllers\Article\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\v2\ArticleResource;

use App\services\Article\v2\ArticlePublishService;

use function PHPUnit\Framework\isEmpty;

class ArticleControllerV2 extends Controller
{

    public function allPublished(ArticlePublishService $service)
    {
        $result=$service->allPublished();
        return ArticleResource::collection($result);
        
    }

}
