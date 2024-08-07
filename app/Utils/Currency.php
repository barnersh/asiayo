<?php

namespace App\Utils;

use Illuminate\Support\Facades\Facade;

/**
 * @method static toTWD($value, \App\Enums\Currency $currency)
 */
class Currency extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'currency.facade';
    }
}
