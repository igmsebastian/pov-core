<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function getUserList(UserFilter $filters)
    {
        $this->userService->get($filters);
    }

    public function createUser(CreateUserRequest $request)
    {

    }
}
