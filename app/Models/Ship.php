<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model {

    /**
     * @var string
     */
    protected $table = 'ship';

    /**
     * @var string[]
     */
    protected $fillable = [
        'imo',
        'name',
        'flag',
        'latitude',
        'longitude',
    ];
}
