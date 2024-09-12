<?php

namespace App\Core\Domain\Ship\Factories;

use App\Core\Domain\Ship\Entities\Ship;

interface ExternalShipLocationFactory
{
    /**
     * @param $imo
     * @param $externalSystem
     * @return Ship
     */
    public function searchShipsLocation($imo, $externalSystem): Ship;
}
