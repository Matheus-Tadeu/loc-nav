<?php

namespace App\Adapter\Infra;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Repositories\FindShipLocationRepository;
use App\Core\Domain\Ship\Repositories\SaveCacheShipLocationRepository;
use Illuminate\Support\Facades\Redis;

class RedisShipLocationRepositoryImp implements SaveCacheShipLocationRepository, FindShipLocationRepository
{
    /**
     * @param Ship $ship
     * @return Ship
     */
    public function save(Ship $ship): Ship
    {
        $key = "ship_imo:{$ship->imo}";
        $expiration = 60;
        Redis::setex($key, $expiration, json_encode($ship));
        return $ship;
    }

    /**
     * @param int $imo
     * @return Ship|null
     */
    public function findByImo(int $imo): ?Ship
    {
        $data = Redis::get("ship_imo:{$imo}");

        if ($data) {
            $formatData = json_decode($data, true);

            if ($formatData) {
                return new Ship(
                    $formatData['imo'],
                    $formatData['name'],
                    $formatData['flag'],
                    $formatData['latitude'],
                    $formatData['longitude']
                );
            }
        }

        return null;
    }
}
