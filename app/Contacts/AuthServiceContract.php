<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\UploadedFile;

interface AuthServiceContract
{
    public function login(LoginRequest $request): ApiJsonResponse;
}
