<?php

namespace App\Http\Controllers;

use App\Core\Domain\Ship\Services\ShipsLocationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *     path="/api/ships/location",
 *     summary="Get all ships locations",
 *     tags={"Ships"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="imo", type="integer", example=9943267),
 *                 @OA\Property(property="name", type="string", example="EVER ACME"),
 *                 @OA\Property(property="flag", type="string", example="Singapore"),
 *                 @OA\Property(property="latitude", type="string", example="-34"),
 *                 @OA\Property(property="longitude", type="string", example="26"),
 *                 @OA\Property(property="external_system", type="string", example="VESSEL_FINDER")
 *             )
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
        } catch (Exception $e) {
            Log::error('error.internal', ['exception' => $e]);
            return response()->json(['message' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}
