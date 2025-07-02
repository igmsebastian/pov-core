<?php

namespace App\Services;

use Exception;
use App\Models\Step;
use App\Support\StepRequestBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class StepRunnerService extends Service
{
    public function run(Step $step, array $extraContext = []): mixed
    {
        [$class, $method] = explode('@', $step->exec);

        // Merge DB configs with runtime context
        $config = array_merge($step->configs ?? [], $extraContext);

        try {
            return match ($step->exec_type) {
                'service' => $this->runService($class, $method, $config),
                'controller' => $this->runController($class, $method, $config),
                'job' => $this->dispatchJob($class, $method, $config),
                'command' => $this->runCommand($class, $method, $config),
                default => throw new \Exception("Unknown exec_type [{$step->exec_type}]")
            };
        } catch (\Throwable $e) {
            Log::error("Step execution failed: " . $e->getMessage(), [
                'step' => $step->id,
                'exec' => $step->exec,
                'type' => $step->exec_type,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function runService(string $class, string $method, array $data): mixed
    {
        $service = app($class);
        return $service->$method($data);
    }

    protected function runController(string $class, string $method, array $config): mixed
    {
        $controller = app($class);
        $args = StepRequestBuilder::build($class, $method, $config);
        return $controller->$method(...$args);
    }

    protected function dispatchJob(string $class, string $method, array $data): mixed
    {
        $job = app($class);
        return dispatch($job->$method(...array_values($data)));
    }

    protected function runCommand(string $class, string $method, array $data): mixed
    {
        return Artisan::call($class, $data);
    }
}
