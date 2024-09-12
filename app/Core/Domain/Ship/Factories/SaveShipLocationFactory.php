<?php

namespace App\Core\Domain\Ship\Factories;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Enum\DatabaseType;

interface SaveShipLocationFactory
{
    /**
     * @param Ship $ship
     * @param DatabaseType $db
     * @return Ship
     */
    public function save(Ship $ship, DatabaseType $db): Ship;
}
