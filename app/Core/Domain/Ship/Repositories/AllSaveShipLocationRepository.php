<?php

namespace App\Core\Domain\Ship\Repositories;

use Illuminate\Support\Collection;

interface AllSaveShipLocationRepository
{
    /**
     * @return Collection|null
     */
    public function all(): Collection|null;
}
