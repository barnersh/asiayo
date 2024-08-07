<?php

namespace App\Utils;

use App\Enums\Currency;

class CurrencyService
{
    const int TWD_USD_EXCHANGE_RATE = 31;
    public function toTWD($value, \App\Enums\Currency $currency)
    {
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

        return $twdValue;
    }

}
