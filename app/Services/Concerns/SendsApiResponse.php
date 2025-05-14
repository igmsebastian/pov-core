<?php

namespace App\Services\Concerns;

use Exception;
use JsonSerializable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpFoundation\Response;

trait SendsApiResponse
{
    private ?string $success = 'success';
    private ?string $error = 'error';

    private function response(array $data, int $code = 200): JsonResponse
    {

        return response()->json($data, $code);
    }

    public function sendOkResponse(string $message = 'Done'): JsonResponse
    {
        return $this->sendWithSuccessResponse([
            'status' => $this->success,
            'message' => $message
        ]);
    }

    /**
     * @param array|Arrayable|JsonSerializable|null $contents
     */
    public function sendWithSuccessResponse($contents = []): JsonResponse
    {
        $contents = $this->morphToArray($contents);

        $data = [] === $contents
            ? $this->setSuccessStatusContent
            : $contents;

        return $this->response($data);
    }

    /**
     * @param string|\Exception $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotFoundResponse(
        $message,
    ): JsonResponse {
        return $this->response(
            [
                'status' => $this->error,
                'message' => $this->morphMessage($message)
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    public function sendUnauthenticatedResponse(?string $message = 'unauthenticated'): JsonResponse
    {
        return $this->response(
            [
                'status' => $this->error,
                'message' => $message
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function sendForbiddenResponse(?string $message = 'Forbidden'): JsonResponse
    {
        return $this->response(
            [
                'status' => $this->error,
                'message' => $message
            ],
            Response::HTTP_FORBIDDEN
        );
    }

    public function sendErrorResponse(string|\Exception $message = 'Error'): JsonResponse
    {
        return $this->response(
            [
                'status' => $this->error,
                'message' => $this->morphMessage($message)
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param array|Arrayable|JsonSerializable|null $data
     * @return array|null
     */
    private function morphToArray($data)
    {
        if ($data instanceof Arrayable) {
            return $data->toArray();
        }

        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        }

        return $data;
    }

    /**
     * @param string|\Exception $message
     * @return string
     */
    private function morphMessage($message): string
    {
        $message = $message instanceof Exception
            ? $message->getMessage()
            : $message;

        Log::error($message);

        return $message;
    }
}