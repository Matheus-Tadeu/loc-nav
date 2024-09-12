<?php

namespace App\Adapter\Infra\ExternalServices\Contracts;

interface Crawler
{
    /**
     * @param int $imo
     * @return array
     */
    public function getDetailsByImo(int $imo): array;
}
