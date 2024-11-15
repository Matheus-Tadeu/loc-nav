<?php

namespace App\Core\Domain\Ship\Factories;

use App\Core\Domain\Ship\Entities\Ship;
use App\Exceptions\ExternalServiceException;

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
     * @param int $imo
     * @param int $externalSystemId
     * @return Ship
     */
    public function searchShipsLocation(int $imo, int $externalSystemId): Ship
    {
        if (!isset($this->shipsLocationExternalService[$externalSystemId])) {
            throw new ExternalServiceException();
        }

        return $this->shipsLocationExternalService[$externalSystemId]->searchLocation($imo);
    }
}
