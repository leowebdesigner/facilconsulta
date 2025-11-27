<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DoctorResource;
use App\Services\DoctorService;
use App\Traits\Http\HandlesExceptionsTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use HandlesExceptionsTrait;

    public function __construct(private readonly DoctorService $doctorService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return $this->safeCall(function () use ($request) {
            $doctors = $this->doctorService->list($request->only(['specialty', 'active']), $request->integer('per_page', 15));

            return $this->successResponse([
                'doctors' => DoctorResource::collection($doctors),
            ]);
        });
    }

    public function available(Request $request): JsonResponse
    {
        return $this->safeCall(function () use ($request) {
            $date = $request->query('date', now()->toDateString());
            $specialty = $request->query('specialty');
            $doctors = $this->doctorService->listAvailable($date, $specialty);

            return $this->successResponse([
                'doctors' => DoctorResource::collection($doctors),
            ]);
        });
    }
}
