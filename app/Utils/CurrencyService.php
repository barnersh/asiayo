<?php

namespace App\Utils;

use App\Enums\Currency;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    const int TWD_USD_EXCHANGE_RATE = 31;
    public function toTWD($value, \App\Enums\Currency $currency)
    {
        if (!is_int($value) && !is_float($value)) {
            return false;
        }

        $twdValue = 0;

        switch ($currency) {
            case Currency::TWD:
                $twdValue = $value;
                break;
            case Currency::USD:
                // todo: 可能有小數點產生，真實情境可能需要考慮小數點位數
                $twdValue = $value * self::TWD_USD_EXCHANGE_RATE;
                break;
        }

        if ($twdValue < 0) {
            $twdValue = 0;
        }

        return $twdValue;
    }

}
