<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\User\UserResource;
use App\services\User\UserDashboardService;
use Illuminate\Http\Request;
use App\services\User\RegisterRequestService;

class UserController extends Controller
{
    
    public function dashboard(UserDashboardService $service)
    {
        try{
            $result=$service->dashboard();
            return new UserResource($result);
        }
        catch(\Exception $e)
        {
            $statusCode = ($e->getCode() >= 400 && $e->getCode() <= 500) ? $e->getCode() : 500;

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], $statusCode);
        }
    }

    public function Register(RegisterRequest $request,RegisterRequestService $service)
    {
        $result=$service->Register($request->validated());
        if($result)
            return response()->json([
            'message'=>'Registred successfuly',
        ]);
    }

    public function login(LoginRequest $request,RegisterRequestService $service)
    {
        $result=$service->login($request->validated());
        if($result)
            return response()->json([
            'message'=>'wellcome !',
            'data'=>$result
        ]);
        return response()->json([
            'message'=>'Invalid email or password',
        ],401);
    }

}
