<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Filters\ModuleFilter;
use App\Services\ModuleService;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\QueryParam;
use App\Http\Resources\Module\ModuleResource;
use Knuckles\Scribe\Attributes\Authenticated;
use App\Http\Requests\Module\GetModuleRequest;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use App\Http\Requests\Module\CreateModuleRequest;
use App\Http\Requests\Module\DeleteModuleRequest;
use App\Http\Requests\Module\UpdateModuleRequest;
use App\Http\Resources\Module\ModuleListResource;
use App\Http\Requests\Module\GetModuleInitRequest;
use App\Http\Requests\Module\UpdateModuleStatusRequest;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("Module Management", "APIs for managing modules")]
class ModuleController extends Controller
{
    public function __construct(
        private ModuleService $moduleService,
    ) {}

    /**
     * List of modules
     *
     * Retrieve a paginated, filtered list of modules.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[QueryParam("keyword", "Filter by keyword.", required: false, nullable: true)]
    #[QueryParam("name", "Filter by name.", required: false, nullable: true)]
    #[QueryParam("code", "Filter by code.", required: false, nullable: true)]
    #[QueryParam("status", "Filter by status.", required: false, nullable: true)]
    #[QueryParam("samaccountname", "Filter by samaccountname.", required: false, nullable: true)]
    #[ResponseFromApiResource(ModuleListResource::class, Module::class, collection: true, paginate: 10)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getModuleList(ModuleFilter $filters)
    {
        return $this->moduleService->getModules($filters);
    }

    /**
     * Initial module form
     *
     * Fetch initial data (statuses, permissions, modules) for module form setup.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromFile("storage/responses/module/init-data.get.json")]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getInit(GetModuleInitRequest $request)
    {
        return $this->moduleService->getFormInit();
    }

    /**
     * Fetch module details
     *
     * Retrieve detailed information for a single module.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(ModuleResource::class, Module::class)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getModule(GetModuleRequest $request, Module $module)
    {
        return $this->moduleService->getModule($module);
    }

    /**
     * Create new module
     *
     * Validate and create a new module record.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(ModuleResource::class, Module::class)]
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
    public function createModule(CreateModuleRequest $request)
    {
        return $this->moduleService->createModule($request);
    }

    /**
     * Update existing module
     *
     * Validate and update an existing module information.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(ModuleResource::class, Module::class)]
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
    public function updateModule(UpdateModuleRequest $request, Module $module)
    {
        return $this->moduleService->updateModule($request, $module);
    }

    /**
     * Update Status for set of modules
     *
     * Change the status of one or more module instantly.
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
    public function updateModuleStatus(UpdateModuleStatusRequest $request, Module $module)
    {
        return $this->moduleService->updateModule($request, $module);
    }

    /**
     * Delete set of modules
     *
     * Delete one or more modules by their IDs.
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
    public function deleteModules(DeleteModuleRequest $request)
    {
        return $this->moduleService->deleteModules($request);
    }
}
