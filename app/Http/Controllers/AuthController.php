<?php

namespace App\Http\Controllers;

use App\Contracts\AuthServiceContract;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceContract $service)
    {
    }

    public function login(LoginRequest $request)
    {

    }
}
