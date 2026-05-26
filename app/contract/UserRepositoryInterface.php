<?php

namespace App\contract;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function register($data);

    public function login($data);
    
    public function report();

}
