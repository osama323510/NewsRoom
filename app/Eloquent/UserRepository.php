<?php

namespace App\Eloquent;
use App\Models\Article;
use Illuminate\Support\Collection;
use App\contract\ArticleRepositoryInterface;
use App\contract\UserRepositoryInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        
    }

    public function register($data)
    {
        $result = User::create($data);
        return $result;
    }

    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
        throw new \Exception('Invalid credentials', 401); 
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token
        ];
    }

    public function report()
    {
        $writersReport = User::where('role', 'writer')
            ->withCount(['articles' => function ($query) {
                $query->where('status', 'published')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
            }])->get();
        return $writersReport;

    }


    
}

