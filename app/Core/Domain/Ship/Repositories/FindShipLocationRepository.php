<?php

namespace App\Core\Domain\Ship\Repositories;

use App\Core\Domain\Ship\Entities\Ship;
use Illuminate\Support\Collection;

interface FindShipLocationRepository
{
    /**
     * @param int $imo
     * @return Ship|null
     */
    public function findByImo(int $imo): Ship|null;
}
