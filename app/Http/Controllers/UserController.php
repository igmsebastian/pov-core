<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Services\UserService;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\Response;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\GetUserRequest;
use Knuckles\Scribe\Attributes\QueryParam;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserListResource;
use Knuckles\Scribe\Attributes\Authenticated;
use App\Http\Requests\User\GetUserInitRequest;
use App\Http\Resources\User\UserShortResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use App\Http\Requests\User\UpdateUserStatusRequest;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("User Management", "APIs for managing users")]
class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
    ) {}

    /**
     * List of users
     *
     * Retrieve a paginated, filtered list of users.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[QueryParam("keyword", "Filter by keyword.", required: false, nullable: true)]
    #[QueryParam("email", "Filter by email.", required: false, nullable: true)]
    #[QueryParam("name", "Filter by name.", required: false, nullable: true)]
    #[QueryParam("samaccountname", "Filter by samaccountname.", required: false, nullable: true)]
    #[ResponseFromApiResource(UserListResource::class, User::class, collection: true, paginate: 10)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getUserList(UserFilter $filters)
    {
        return $this->userService->getUsers($filters);
    }

    /**
     * Initial user form
     *
     * Fetch initial data (statuses, permissions, modules) for user form setup.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromFile("storage/responses/user/init-data.get.json")]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getInit(GetUserInitRequest $request)
    {
        return $this->userService->getFormInit();
    }

    /**
     * Fetch user details
     *
     * Retrieve detailed information for a single user.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(UserResource::class, User::class)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getUser(GetUserRequest $request, User $user)
    {
        return $this->userService->getUser($user);
    }

    /**
     * Create new user
     *
     * Validate and create a new user record.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(UserShortResource::class, User::class)]
    #[Response(status: 400, description: 'Bad Request', content: '{"message": "Bad Request."}')]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(
        status: 422,
        description: 'Validation Error',
        content: '{
  "message": "The given data was invalid.",
  "errors": {
    "fieldName": ["error-message."],
  }
}'
    )]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function createUser(CreateUserRequest $request)
    {
        return $this->userService->registerUser($request);
    }

    /**
     * Update existing user
     *
     * Validate and update an existing user’s information.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(UserShortResource::class, User::class)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(
        status: 422,
        description: 'Validation Error',
        content: '{
  "message": "The given data was invalid.",
  "errors": {
    "fieldName": ["error-message."],
  }
}'
    )]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function updateUser(UpdateUserRequest $request, User $user)
    {
        return $this->userService->updateUser($request, $user);
    }

    /**
     * Update Status for set of users
     *
     * Change the status of one or more user instantly.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromFile("storage/responses/success.json")]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(
        status: 422,
        description: 'Validation Error',
        content: '{
  "message": "The given data was invalid.",
  "errors": {
    "fieldName": ["error-message."],
  }
}'
    )]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function updateUserStatus(UpdateUserStatusRequest $request, User $user)
    {
        return $this->userService->updateUser($request, $user);
    }

    /**
     * Delete set of users
     *
     * Delete one or more users by their IDs.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromFile("storage/responses/success.json")]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(
        status: 422,
        description: 'Validation Error',
        content: '{
  "message": "The given data was invalid.",
  "errors": {
    "fieldName": ["error-message."],
  }
}'
    )]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function deleteUsers(DeleteUserRequest $request)
    {
        return $this->userService->deleteUsers($request);
    }
}
