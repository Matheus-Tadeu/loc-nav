<?php

namespace App\Core\Domain\Ship\Services;

use App\Core\Domain\Ship\Entities\Ship;

interface ShipLocationExternalService
{
    /**
     * @param $imo
     * @return Ship
     */
    public function searchLocation($imo): Ship;
}
