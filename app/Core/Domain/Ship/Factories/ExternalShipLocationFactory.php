<?php

namespace App\Core\Domain\Ship\Factories;

use App\Core\Domain\Ship\Entities\Ship;

interface ExternalShipLocationFactory
{
    /**
     * @param int $imo
     * @param int $externalSystemId
     * @return Ship
     */
    public function searchShipsLocation(int $imo, int $externalSystemId): Ship;
}
