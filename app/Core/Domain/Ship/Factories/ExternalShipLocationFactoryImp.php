<?php

namespace App\Core\Domain\Ship\Factories;

use App\Core\Domain\Ship\Entities\Ship;
use InvalidArgumentException;

class ExternalShipLocationFactoryImp implements ExternalShipLocationFactory
{
    /**
     * @var array
     */
    private array $shipsLocationExternalService;

    /**
     * @param $ShipsLocationExternalService
     */
    public function __construct($ShipsLocationExternalService)
    {
        $this->shipsLocationExternalService = $ShipsLocationExternalService;
    }

    /**
     * @param $imo
     * @param $externalSystem
     * @return Ship
     */
    public function searchShipsLocation($imo, $externalSystem): Ship
    {
        if (!isset($this->shipsLocationExternalService[$externalSystem])) {
            throw new InvalidArgumentException("Invalid external service!", 422);
        }

        return $this->shipsLocationExternalService[$externalSystem]->searchLocation($imo);
    }
}
