<?php

namespace App\Core\Domain\Ship\Services;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Enum\DatabaseType;
use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Factories\ExternalShipLocationFactory;
use App\Core\Domain\Ship\Factories\SaveShipLocationFactory;
use App\Core\Domain\Ship\Repositories\AllSaveShipLocationRepository;
use App\Core\Domain\Ship\Repositories\FindShipLocationRepository;
use App\Exceptions\ExternalServiceException;
use Illuminate\Support\Collection;

class ShipsLocationService
{
    /**
     * @var ExternalShipLocationFactory
     */
    private ExternalShipLocationFactory $externalShipLocationFactory;

    /**
     * @var FindShipLocationRepository
     */
    private FindShipLocationRepository $findShipLocationRepository;

    /**
     * @var AllSaveShipLocationRepository
     */
    private AllSaveShipLocationRepository $allShipLocationRepository;

    /**
     * @var SaveShipLocationFactory
     */
    private SaveShipLocationFactory $saveShipLocationFactory;

    /**
     * @param ExternalShipLocationFactory $externalShipLocationFactory
     * @param FindShipLocationRepository $findShipLocationRepository
     * @param AllSaveShipLocationRepository $allShipLocationRepository
     * @param SaveShipLocationFactory $saveShipLocationFactory
     */
    public function __construct(
        ExternalShipLocationFactory $externalShipLocationFactory,
        FindShipLocationRepository $findShipLocationRepository,
        AllSaveShipLocationRepository $allShipLocationRepository,
        SaveShipLocationFactory $saveShipLocationFactory
    )
    {
        $this->externalShipLocationFactory = $externalShipLocationFactory;
        $this->findShipLocationRepository = $findShipLocationRepository;
        $this->allShipLocationRepository = $allShipLocationRepository;
        $this->saveShipLocationFactory = $saveShipLocationFactory;
    }

    /**
     * @param int $imo
     * @param int $externalSystemId
     * @return Ship
     * @throws ExternalServiceException
     */
    public function searchShipsLocation(int $imo, int $externalSystemId): Ship
    {
        if (!ExternalSystem::tryFrom($externalSystemId)) {
            throw new ExternalServiceException();
        }

        $ship = $this->externalShipLocationFactory->searchShipsLocation($imo, $externalSystemId);

        if ($shipsLocation = $this->findShipLocationRepository->findByImo($ship)) {
            return $shipsLocation;
        }

        $ship = $this->saveShipLocationFactory->save($ship, DatabaseType::MYSQL);
        $this->saveShipLocationFactory->save($ship, DatabaseType::REDIS);

        return $ship;
    }

    /**
     * @return Collection|null
     */
    public function all(): Collection|null
    {
        return $this->allShipLocationRepository->all();
    }
}
