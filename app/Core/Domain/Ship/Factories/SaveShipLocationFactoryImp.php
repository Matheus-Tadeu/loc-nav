<?php

namespace App\Core\Domain\Ship\Factories;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Enum\DatabaseType;
use App\Core\Domain\Ship\Repositories\SaveCacheShipLocationRepository;
use App\Core\Domain\Ship\Repositories\SaveShipLocationRepository;

class SaveShipLocationFactoryImp implements SaveShipLocationFactory
{
    /**
     * @var SaveShipLocationRepository
     */
    private SaveShipLocationRepository $saveShipLocationRepository;

    /**
     * @var SaveCacheShipLocationRepository
     */
    private SaveCacheShipLocationRepository $saveCacheShipLocationRepository;

    public function __construct(
        SaveShipLocationRepository $saveShipLocationRepository,
        SaveCacheShipLocationRepository $saveCacheShipLocationRepository)
    {
        $this->saveShipLocationRepository = $saveShipLocationRepository;
        $this->saveCacheShipLocationRepository = $saveCacheShipLocationRepository;
    }

    /**
     * @param Ship $ship
     * @param DatabaseType $db
     * @return Ship
     */
    public function save(Ship $ship, DatabaseType $db): Ship
    {
        return match ($db) {
            DatabaseType::MYSQL => $this->saveShipLocationRepository->save($ship),
            DatabaseType::REDIS => $this->saveCacheShipLocationRepository->save($ship),
            default => false,
        };
    }
}
