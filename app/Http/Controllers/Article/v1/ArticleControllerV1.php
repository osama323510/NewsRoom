<?php

namespace App\Http\Controllers\Article\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleCreateRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;

use App\Http\Resources\Article\v1\ArticleResource;

use App\services\Article\v1\ArticleCreateService;
use App\services\Article\v1\ArticleDeleteService;
use App\services\Article\v1\ArticleNewPublishService;
use App\services\Article\v1\ArticlePublishService;
use App\services\Article\v1\ArticleShowService;
use App\services\Article\v1\ArticleUpdateService;

use function PHPUnit\Framework\isEmpty;

class ArticleControllerV1 extends Controller
{

    public function allPublished(ArticlePublishService $service)
    {
        $result=$service->allPublished();
        return ArticleResource::collection($result);
        
    }


    public function find($id,ArticleShowService $service)
    {
        $result=$service->find($id);
        return new ArticleResource($result);
    }


    public function delete($id,ArticleDeleteService $service)
    {
        $service->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'the article has been deleted successfully'
        ], 200);

    }

    public function create(ArticleCreateRequest $request,ArticleCreateService $service)
    {
        $result=$service->create($request->validated());
        return new ArticleResource($result);
    }


    public function publish($id,ArticleNewPublishService $service)
    {
        $result=$service->publish($id);
        if($result)
            return response()->json([
                'status' => 'success',
                'message' => 'the article has been published successfully'
            ], 200);
    }


    public function update($id,ArticleUpdateRequest $request,ArticleUpdateService $service)
    {
        $result=$service->update($id, $request->validated());
        if($result)
            return response()->json([
                'status' => 'success',
                'message' => 'the article has been updated successfully'
            ], 200);
    }


}
