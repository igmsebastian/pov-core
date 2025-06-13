<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Module;
use App\Models\Permission;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use App\Enums\UserStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        try
        {
            DB::beginTransaction();

            $data = $request->all();

            $user = $this->userRepository->create($data);

            if (config('ldap.enabled') === true && $this->authService->isLdapAvailable()) {
                $this->authService->requireLdapSync($request->samaccountname);
            }

            DB::commit();

            return new UserShortResource($user);
        } catch (Exception $e) {
            Log::critical(sprintf(
                'USERCREATEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $user = $this->userRepository->update($user, $data);

            if (config('ldap.enabled') === true && $this->authService->isLdapAvailable()) {
                $this->authService->requireLdapSync($request->samaccountname);
            }

            DB::commit();

            return new UserShortResource($user);
        } catch (Exception $e) {
            Log::critical(sprintf(
                'USERUPDATEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }

    public function deleteUsers(Request $request)
    {
        try {
            DB::beginTransaction();

            User::destroy($request->ids);

            return $this->sendOkResponse();
        } catch (Exception $e) {
            Log::critical(sprintf(
                'USERDELETEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }
}
