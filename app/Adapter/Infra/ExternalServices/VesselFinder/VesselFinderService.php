<?php

namespace App\Adapter\Infra\ExternalServices\VesselFinder;

use App\Core\Domain\Ship\Entities\Ship;
use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Services\ShipLocationExternalService;
use Exception;

class VesselFinderService implements ShipLocationExternalService
{
    /**
     * @var VesselFinderCrawler
     */
    private VesselFinderCrawler $crawler;

    /**
     * @param VesselFinderCrawler $crawler
     */
    public function __construct(VesselFinderCrawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param $imo
     * @return Ship
     * @throws Exception
     */
    public function searchLocation($imo): Ship
    {
        $data = $this->crawler->getDetailsByImo($imo);

        return new Ship($imo, $data['name'], $data['flag'], $data['latitude'], $data['longitude'], ExternalSystem::VESSEL_FINDER->name);
    }
}
