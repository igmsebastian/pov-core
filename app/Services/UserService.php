<?php

namespace App\Services;

use App\Models\User;
use App\Models\Module;
use App\Models\LdapUser;
use App\Models\Permission;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Enums\UserStatusEnum;
use App\Repositories\UserRepository;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserShortResource;

class UserService extends Service
{
    public function __construct(
        protected AuthService $authService,
        private UserRepository $userRepository,
    ) {}

    public function getUsers(UserFilter $filters)
    {
        $users = $this->userRepository->fetchAll($filters);

        return  UserListResource::collection($this->paginate($users));
    }

    public function getFormInit()
    {
        return $this->sendWithSuccessResponse([
            'statuses' => UserStatusEnum::options(),
            'permissions' => Permission::abilitiesByResource(),
            'modules' => Module::allModules(),
        ]);
    }

    public function getUser(User $user)
    {
        return new UserResource($user);
    }

    public function registerUser(Request $request)
    {
        $data = $request->all();

        $user = $this->userRepository->create($data);

        if (config('ldap.enabled') === true && $this->authService->isLdapAvailable()) {
            $ldapUser = LdapUser::firstWhere('samaccountname', $request->samaccountname);
            $this->userRepository->syncLdapUser($ldapUser);
        }

        return new UserShortResource($user);
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->all();

        $this->userRepository->update($user, $data);

        return $this->sendOkResponse();
    }

    public function deleteUsers(Request $request)
    {
        User::destroy($request->ids);

        return $this->sendOkResponse();
    }
}
