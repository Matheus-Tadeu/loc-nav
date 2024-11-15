<?php

namespace App\Http\Controllers;

use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Services\ShipsLocationService;
use App\Exceptions\ExternalServiceException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class SearchShipsLocationController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/ships/location/{imo}/{externalSystemId}",
     *     summary="Search ship location by IMO and external system",
     *     tags={"Ships"},
     *     @OA\Parameter(
     *         name="imo",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=9839131)
     *     ),
     *     @OA\Parameter(
     *         name="externalSystemId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="imo", type="integer", example=9839131),
     *             @OA\Property(property="name", type="string", example="CC CHAMPS ELYSEES"),
     *             @OA\Property(property="flag", type="string", example="France"),
     *             @OA\Property(property="latitude", type="string", example="-34"),
     *             @OA\Property(property="longitude", type="string", example="18"),
     *             @OA\Property(property="external_system", type="string", example="VESSEL_FINDER")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid external service",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid external service!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="IMO not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="IMO not found!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred. Please try again later.")
     *         )
     *     )
     * )
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
        } catch (ExternalServiceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            Log::error('error.internal', ['exception' => $e]);
            return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}
