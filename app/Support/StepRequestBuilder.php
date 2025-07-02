<?php

namespace App\Support;

use ReflectionMethod;
use ReflectionNamedType;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class StepRequestBuilder
{
    /**
      * {
      *   "_method": "GET",
      *   "_uri": "/users/123",
      *   "_route": { "user": 123 },
      *   "_query": { "status": "active" }
      * }

      * {
      *   "_method": "POST",
      *   "_uri": "/invoices",
      *   "_body": {
      *     "user_id": 1,
      *     "amount": 500,
      *     "due_date": "2025-08-01"
      *   }
      * }

      * {
      *   "_method": "PATCH",
      *   "_uri": "/projects/5",
      *   "_route": { "project": 5 },
      *   "_body": { "status": "completed" }
      * }
     */
    public static function build(string $controllerClass, string $method, array $config): array
    {
        $httpMethod   = strtoupper($config['_method'] ?? 'POST');
        $uri          = $config['_uri'] ?? '/fake-uri';
        $queryParams  = $config['_query'] ?? [];
        $bodyParams   = $config['_body'] ?? [];
        $headers      = $config['_headers'] ?? [];

        // Compose the full URI with query string
        if (!empty($queryParams)) {
            $uri .= '?' . http_build_query($queryParams);
        }

        // Create the base request
        $request = Request::create($uri, $httpMethod, $bodyParams);
        foreach ($headers as $key => $val) {
            $request->headers->set($key, $val);
        }

        // Reflect the method to resolve parameters
        $reflection = new ReflectionMethod($controllerClass, $method);
        $args = [];

        foreach ($reflection->getParameters() as $param) {
            $type = $param->getType();

            if ($type instanceof ReflectionNamedType) {
                $typeName = $type->getName();

                // FormRequest: apply validation
                if (is_subclass_of($typeName, FormRequest::class)) {
                    $formRequest = app($typeName);
                    $formRequest->setContainer(app())->setRedirector(app('redirect'));

                    $formRequest->initialize(
                        $request->query->all(),
                        $request->request->all(),
                        $request->attributes->all(),
                        $request->cookies->all(),
                        $request->files->all(),
                        $request->server->all(),
                        $request->getContent()
                    );

                    $formRequest->setMethod($httpMethod);
                    $formRequest->headers->replace($request->headers->all());
                    $formRequest->validateResolved(); // ✅ Validate
                    $args[] = $formRequest;

                } elseif ($typeName === Request::class) {
                    $args[] = $request;

                } else {
                    $args[] = null;
                }
            } else {
                $args[] = null;
            }
        }

        return $args;
    }
}
