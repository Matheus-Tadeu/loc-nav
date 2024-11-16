<?php

namespace App\Adapter\Infra;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Repositories\FindShipLocationRepository;
use App\Core\Domain\Ship\Repositories\SaveCacheShipLocationRepository;
use Illuminate\Support\Facades\Redis;

class RedisShipLocationRepositoryImp implements SaveCacheShipLocationRepository, FindShipLocationRepository
{
    private const KEY = 'ship_imo:%s_external_system_%s_lat_%s_long_%s';
    private const EXPIRATION = 60;

    /**
     * @param Ship $ship
     * @return Ship
     */
    public function save(Ship $ship): Ship
    {
        $key = $this->contructKey($ship);
        Redis::setex($key, self::EXPIRATION, json_encode($ship));
        return $ship;
    }

    /**
     * @param Ship $ship
     * @return Ship|null
     */
    public function findByImo(Ship $ship): ?Ship
    {
        $key = $this->contructKey($ship);
        $data = Redis::get($key);

        if ($data) {
            $formatData = json_decode($data, true);

            if ($formatData) {
                return new Ship(
                    $formatData['imo'],
                    $formatData['name'],
                    $formatData['flag'],
                    $formatData['latitude'],
                    $formatData['longitude'],
                    $formatData['external_system']
                );
            }
        }

        return null;
    }

    /**
     * @param Ship $ship
     * @return string
     */
    public function contructKey(Ship $ship): string
    {
        return sprintf(self::KEY, $ship->imo, $ship->external_system, $ship->latitude, $ship->longitude);
    }
}
