<?php

namespace App\Core\Domain\Ship\Repositories;

use App\Core\Domain\Ship\Entities\Ship;

interface SaveCacheShipLocationRepository
{
    /**
     * @param Ship $ship
     * @return Ship
     */
    public function save(Ship $ship): Ship;
}
