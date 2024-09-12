<?php

namespace App\Http\Controllers;

use App\Core\Domain\Ship\Services\ShipsLocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class AllShipsLocationController extends BaseController
{
    /**
     * @var ShipsLocationService
     */
    private ShipsLocationService $shipLocationService;

    /**
     * @param ShipsLocationService $shipLocationService
     */
    public function __construct(ShipsLocationService $shipLocationService)
    {
        $this->shipLocationService = $shipLocationService;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        try {
            $ship = $this->shipLocationService->all();
            return response()->json($ship->toArray());
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
