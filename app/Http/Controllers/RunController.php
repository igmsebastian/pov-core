<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;
use App\Services\StepRunnerService;

class RunController extends Controller
{
    public function __construct(
        private StepRunnerService $stepRunnerService,
    ) {}

    public function execute(Request $request, Step $step)
    {
        $extra = $request->all(); // Any runtime overrides or inputs
        $result = $this->stepRunnerService->run($step, $extra);

        return response()->json([
            'status' => 'success',
            'step_id' => $step->id,
            'result' => $result,
        ]);
    }
}
