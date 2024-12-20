<?php

namespace App\Core\Domain\Ship\Entities;

class Ship
{
    /**
     * @var int
     * The International Maritime Organization (IMO) number of the ship.
     */
    public int $imo;

    /**
     *
     * @var string
     * The name of the ship.
     */
    public string $name;

    /**
     * @var string
     * The flag of the ship.
     */
    public string $flag;

    /**
     * @var string
     * The latitude of the ship.
     */
    public string $latitude;

    /**
     * @var string
     * The longitude of the ship.
     */
    public string $longitude;

    /**
     * @var string
     * The external system of the ship.
     */
    public string $external_system;

    /**
     * @param int $imo
     * @param string $name
     * @param string $flag
     * @param float $latitude
     * @param float $longitude
     * @param string $externalSystem
     */
    public function __construct(int $imo, string $name, string $flag, float $latitude, float $longitude, string $externalSystem)
    {
        $this->imo = $imo;
        $this->name = $name;
        $this->flag = $flag;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->external_system = $externalSystem;
    }

    public function toArray(): array
    {
        return [
            'imo' => $this->imo,
            'name' => $this->name,
            'flag' => $this->flag,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'external_system' => $this->external_system
        ];
    }
}
