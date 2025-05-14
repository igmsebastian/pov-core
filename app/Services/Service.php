<?php

namespace App\Services;

use App\Services\Concerns\HandlesApi;
use App\Services\Concerns\SendsApiResponse;
use App\Services\Concerns\HasCollectionPagination;

class Service
{
    use HasCollectionPagination, SendsApiResponse, HandlesApi;
}