<?php

namespace App\Adapter\Infra;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Repositories\AllSaveShipLocationRepository;
use App\Core\Domain\Ship\Repositories\SaveShipLocationRepository;
use App\Models\Ship as ShipModel;
use Illuminate\Support\Collection;


class ShipLocationRepositoryImp implements SaveShipLocationRepository, AllSaveShipLocationRepository
{
    /**
     * @var ShipModel
     */
    private ShipModel  $model;

    public function __construct()
    {
        $this->model = app(ShipModel::class);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        $ships = $this->model->all();
        return $ships->map(fn($ship) => new Ship(
            $ship->imo,
            $ship->name,
            $ship->flag,
            $ship->latitude,
            $ship->longitude,
            $ship->external_system
        ));
    }

    /**
     * @param Ship $ship
     * @return Ship
     */
    public function save(Ship $ship): Ship
    {
        $shipLocation =$this->model->updateOrCreate(
            ['imo' => $ship->imo],
            [
                'name' => $ship->name,
                'flag' => $ship->flag,
                'latitude' => $ship->latitude,
                'longitude' => $ship->longitude,
                'external_system' => $ship->external_system
            ]
        );

        return new Ship(
            $shipLocation->imo,
            $shipLocation->name,
            $shipLocation->flag,
            $shipLocation->latitude,
            $shipLocation->longitude,
            $shipLocation->external_system
        );
    }
}
