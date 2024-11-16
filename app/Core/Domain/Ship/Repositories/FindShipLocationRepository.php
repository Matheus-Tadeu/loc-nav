<?php

namespace App\Core\Domain\Ship\Repositories;

use App\Core\Domain\Ship\Entities\Ship;
use Illuminate\Support\Collection;

interface FindShipLocationRepository
{
    /**
     * @param Ship $ship
     * @return Ship|null
     */
    public function findByImo(Ship $ship): Ship|null;
}
