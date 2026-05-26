<?php

namespace App\services\User;

use App\contract\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterRequestService
{
    /**
     * Create a new class instance.
     */
    protected $userRepository;
    public function __construct( UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register($data)
    {
        $result = $this->userRepository->Register($data);
        return $result;
    }

    public function login($data)
    {
        $result = $this->userRepository->Login($data);
        return $result;

    }
}
