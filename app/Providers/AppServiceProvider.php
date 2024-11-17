<?php

namespace App\Providers;

use App\Adapter\Infra\RedisShipLocationRepositoryImp;
use App\Adapter\Infra\ExternalServices\VesselFinder\VesselFinderService;
use App\Adapter\Infra\ShipLocationRepositoryImp;
use App\Core\Domain\Ship\Enum\ExternalSystem;
use App\Core\Domain\Ship\Factories\ExternalShipLocationFactory;
use App\Core\Domain\Ship\Factories\ExternalShipLocationFactoryImp;
use App\Core\Domain\Ship\Factories\SaveShipLocationFactory;
use App\Core\Domain\Ship\Factories\SaveShipLocationFactoryImp;
use App\Core\Domain\Ship\Repositories\AllSaveShipLocationRepository;
use App\Core\Domain\Ship\Repositories\FindShipLocationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExternalShipLocationFactory::class, function ($app) {
            $searchShipsLocationService = [
                ExternalSystem::VESSEL_FINDER->value => $app->make(VesselFinderService::class),
            ];
            return new ExternalShipLocationFactoryImp($searchShipsLocationService);
        });

        $this->app->singleton(SaveShipLocationFactory::class, function ($app) { 
            $saveShipLocationRepository = $app->make(ShipLocationRepositoryImp::class);
            $saveCacheShipLocationRepository = $app->make(RedisShipLocationRepositoryImp::class);
            return new SaveShipLocationFactoryImp($saveShipLocationRepository, $saveCacheShipLocationRepository);
        });

        $this->app->singleton(AllSaveShipLocationRepository::class, ShipLocationRepositoryImp::class);
        $this->app->singleton(FindShipLocationRepository::class, RedisShipLocationRepositoryImp::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
