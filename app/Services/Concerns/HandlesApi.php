<?php

namespace App\Services\Concerns;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

trait HandlesApi
{
    /**
     * @param Request $request
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     * @throws AccessDeniedHttpException
     * @throws ServiceUnavailableHttpException
     * @throws UnauthorizedHttpException
     * @throws UnprocessableEntityHttpException
     */
     public function getResponse(Request $request): object
     {
        $response = app()->handle($request);
        $content = json_decode($response->getContent());

        if (! $response->isSuccessful()) {
            $statusCode = $response->getStatusCode();
            $message = $content->message;

            match ($statusCode) {
                400 => throw new BadRequestHttpException($message),
                401 => throw new UnauthorizedHttpException('', $message),
                403 => throw new AccessDeniedHttpException($message),
                404 => throw new NotFoundHttpException($message),
                422 => throw new UnprocessableEntityHttpException($message),
                503 => throw new ServiceUnavailableHttpException(null, $message),
                default => throw new Exception($message, $statusCode)
            };
        }

        return $content;
     }
}