<?php

namespace App\Services;

use Exception;
use App\Models\Country;
use App\Models\Feature;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use App\Enums\FeatureTypeEnum;
use App\Filters\FeatureFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\FeatureRepository;
use App\Http\Resources\Feature\FeatureResource;
use App\Http\Resources\Feature\FeatureListResource;

class FeatureService extends Service
{
    public function __construct(
        private FeatureRepository $featureRepository,
    ) {}

    public function getFeatures(FeatureFilter $filters)
    {
        $features = $this->featureRepository->fetchAll($filters);

        return  FeatureListResource::collection($this->paginate($features));
    }

    public function getFormInit()
    {
        return $this->sendWithSuccessResponse([
            'statuses' => StatusEnum::commonStatusesForForm(),
            'types' => FeatureTypeEnum::forForm(),
            'countries' => Country::getCountriesForForm(),
        ]);
    }

    public function getFeature(Feature $feature)
    {
        return new FeatureResource($feature);
    }

    public function createFeature(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $feature = $this->featureRepository->create($data);

            DB::commit();

            return new FeatureResource($feature);
        } catch (Exception $e) {
            Log::critical(sprintf(
                'FEATURECREATEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }

    public function updateFeature(Request $request, Feature $feature)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $feature = $this->featureRepository->update($feature, $data);

            DB::commit();

            return new FeatureResource($feature);
        } catch (Exception $e) {
            Log::critical(sprintf(
                'FEATUREUPDATEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }

    public function deleteFeatures(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->featureRepository->delete($request->ids);

            return $this->sendOkResponse();
        } catch (Exception $e) {
            Log::critical(sprintf(
                'FEATUREDELETEEXCEPTION message: %s, file: %s, line: %s',
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));

            DB::rollBack();

            return $this->sendErrorResponse($e);
        }
    }
}
