<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Filters\FeatureFilter;
use App\Services\FeatureService;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Authenticated;
use App\Http\Resources\Feature\FeatureResource;
use App\Http\Requests\Feature\GetFeatureRequest;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use App\Http\Requests\Feature\CreateFeatureRequest;
use App\Http\Requests\Feature\DeleteFeatureRequest;
use App\Http\Requests\Feature\UpdateFeatureRequest;
use App\Http\Resources\Feature\FeatureListResource;
use App\Http\Requests\Feature\GetFeatureInitRequest;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use App\Http\Requests\Feature\UpdateFeatureStatusRequest;

#[Group("Feature Management", "APIs for managing features")]
class FeatureController extends Controller
{
    public function __construct(
        private FeatureService $featureService,
    ) {}

    /**
     * List of features
     *
     * Retrieve a paginated, filtered list of features.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[QueryParam("keyword", "Filter by keyword.", required: false, nullable: true)]
    #[QueryParam("name", "Filter by name.", required: false, nullable: true)]
    #[QueryParam("code", "Filter by code.", required: false, nullable: true)]
    #[QueryParam("type", "Filter by type.", required: false, nullable: true)]
    #[QueryParam("status", "Filter by status.", required: false, nullable: true)]
    #[QueryParam("samaccountname", "Filter by samaccountname.", required: false, nullable: true)]
    #[ResponseFromApiResource(FeatureListResource::class, Feature::class, collection: true, paginate: 10)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getFeatureList(FeatureFilter $filters)
    {
        return $this->featureService->getFeatures($filters);
    }

    /**
     * Initial feature form
     *
     * Fetch initial data (statuses, permissions, features) for feature form setup.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromFile("storage/responses/feature/init-data.get.json")]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getInit(GetFeatureInitRequest $request)
    {
        return $this->featureService->getFormInit();
    }

    /**
     * Fetch feature details
     *
     * Retrieve detailed information for a single feature.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(FeatureResource::class, Feature::class)]
    #[Response(status: 401, description: "Not found", content: '{"message": "Unauthenticated."}')]
    #[Response(status: 403, description: "Forbidden", content: '{"message": "This action is unauthorized."}')]
    #[Response(status: 500, description: 'Internal Server Error', content: '{"message": "Server error."}')]
    public function getFeature(GetFeatureRequest $request, Feature $feature)
    {
        return $this->featureService->getFeature($feature);
    }

    /**
     * Create new feature
     *
     * Validate and create a new feature record.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(FeatureResource::class, Feature::class)]
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
    public function createFeature(CreateFeatureRequest $request)
    {
        return $this->featureService->createFeature($request);
    }

    /**
     * Update existing feature
     *
     * Validate and update an existing feature information.
     */
    #[Authenticated()]
    #[Header("Accept", "application/json")]
    #[ResponseFromApiResource(FeatureResource::class, Feature::class)]
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
    public function updateFeature(UpdateFeatureRequest $request, Feature $feature)
    {
        return $this->featureService->updateFeature($request, $feature);
    }

    /**
     * Update Status for set of features
     *
     * Change the status of one or more feature instantly.
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
    public function updateFeatureStatus(UpdateFeatureStatusRequest $request, Feature $feature)
    {
        return $this->featureService->updateFeature($request, $feature);
    }

    /**
     * Delete set of features
     *
     * Delete one or more features by their IDs.
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
    public function deleteFeatures(DeleteFeatureRequest $request)
    {
        return $this->featureService->deleteFeatures($request);
    }
}
