<?php

namespace App\Core\Domain\Ship\Enum;


enum DatabaseType: string
{
    case MYSQL = 'mysql';
    case REDIS = 'redis';
}
