<?php

namespace App\Utils;

use App\Models\Order;
use Illuminate\Support\Facades\Facade;

/**
 * @method static createOrder(array $data): Order
 */
class OrderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'order.facade';
    }
}
