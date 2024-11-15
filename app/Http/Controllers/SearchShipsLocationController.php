<?php

namespace App\Http\Controllers;

use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Services\ShipsLocationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SearchShipsLocationController extends BaseController
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
     * @param Request $request
     * @param int $imo
     * @param int $externalSystemId
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $imo, int $externalSystemId = ExternalSystem::VESSEL_FINDER->value): JsonResponse
    {
        try {
            $ship = $this->shipLocationService->searchShipsLocation($imo, $externalSystemId);
            return response()->json($ship->toArray());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], !$e->getCode() ? 500 : $e->getCode());
        }
    }
}
