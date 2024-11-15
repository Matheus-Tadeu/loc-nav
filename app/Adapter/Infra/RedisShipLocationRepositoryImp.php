<?php

namespace App\Adapter\Infra;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Repositories\FindShipLocationRepository;
use App\Core\Domain\Ship\Repositories\SaveCacheShipLocationRepository;
use Illuminate\Support\Facades\Redis;

class RedisShipLocationRepositoryImp implements SaveCacheShipLocationRepository, FindShipLocationRepository
{

    private const KEY = 'ship_imo:%s_external_system_%s';

    /**
     * @param Ship $ship
     * @return Ship
     */
    public function save(Ship $ship): Ship
    {
        $key = sprintf(self::KEY, $ship->imo, $ship->external_system);
        $expiration = 60;
        Redis::setex($key, $expiration, json_encode($ship));
        return $ship;
    }

    /**
     * @param int $imo
     * @param int $externalSystemId
     * @return Ship|null
     */
    public function findByImo(int $imo, int $externalSystemId): ?Ship
    {
        $key = sprintf(self::KEY, $imo, ExternalSystem::from($externalSystemId)->name);
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
}
