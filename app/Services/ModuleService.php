<?php

namespace App\Services;

use Exception;
use App\Models\Module;
use App\Models\Country;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use App\Filters\ModuleFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\ModuleRepository;
use App\Http\Resources\Module\ModuleResource;
use App\Http\Resources\Module\ModuleListResource;
use App\Models\Feature;

class ModuleService extends Service
{
    public function __construct(
        private ModuleRepository $moduleRepository,
    ) {}

    public function getModules(ModuleFilter $filters)
    {
        $modules = $this->moduleRepository->fetchAll($filters);

        return  ModuleListResource::collection($this->paginate($modules));
    }

    public function getFormInit()
    {
        return $this->sendWithSuccessResponse([
            'statuses' => StatusEnum::commonStatusesForForm(),
            'countries' => Country::getCountriesForForm(),
            'features' => Feature::getCodeCountryPairs(),
        ]);
    }

    public function getModule(Module $module)
    {
        return new ModuleResource($module);
    }

    public function createModule(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $module = $this->moduleRepository->create($data);

            DB::commit();

            return new ModuleResource($module);
        } catch (Exception $e) {
            Log::critical(sprintf(
                'MODULECREATEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }

    public function updateModule(Request $request, Module $module)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $module = $this->moduleRepository->update($module, $data);

            DB::commit();

            return new ModuleResource($module);
        } catch (Exception $e) {
            Log::critical(sprintf(
                'MODULEUPDATEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }

    public function deleteModules(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->moduleRepository->delete($request->ids);

            return $this->sendOkResponse();
        } catch (Exception $e) {
            Log::critical(sprintf(
                'MODULEDELETEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }
}
