<?php

namespace App\Http\Controllers;

use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Services\ShipsLocationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use InvalidArgumentException;

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
     * @param int $externalSystem
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $imo, int $externalSystem = ExternalSystem::VESSEL_FINDER->value): JsonResponse
    {
        try {
            $ship = $this->shipLocationService->searchShipsLocation($imo, $externalSystem);
            return response()->json($ship->toArray());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], !$e->getCode() ? 500 : $e->getCode());
        }
    }
}
