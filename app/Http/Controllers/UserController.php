<?php

namespace App\Http\Controllers;

use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Services\UserService;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

#[Group("02 - User API Resources")]
class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function getUserList(UserFilter $filters)
    {
        // dd('well done!');
        // $this->userService->get($filters);
    }

    public function getUser(Request $request)
    {
        //
    }

    public function createUser(CreateUserRequest $request)
    {
        //
    }

    public function updateUser(UpdateUserRequest $request)
    {
        //
    }

    public function deleteUser(DeleteUserRequest $request)
    {
        //
    }
}
