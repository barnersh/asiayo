<?php

namespace Tests\Feature;

use App\Enums\Currency;
use App\Utils\CurrencyFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyFacadeTest extends TestCase
{
    public function testValidTransferToTWD()
    {
        $twdToTwd = CurrencyFacade::toTWD(100, Currency::TWD);
        $usdToTwd = CurrencyFacade::toTWD(100, Currency::USD);
        $floatUsdToTwd = CurrencyFacade::toTWD(100.5, Currency::USD);

        $zeroTwdToTwd = CurrencyFacade::toTWD(0, Currency::TWD);
        $zeroUSDToTwd = CurrencyFacade::toTWD(0, Currency::USD);

        $negativeTwdToTwd = CurrencyFacade::toTWD(-100, Currency::TWD);
        $negativeUSDToTwd = CurrencyFacade::toTWD(-100, Currency::USD);

        $this->assertEquals(100, $twdToTwd);
        $this->assertEquals(3100, $usdToTwd);
        $this->assertEquals(3115.5, $floatUsdToTwd);

        $this->assertEquals(0, $zeroTwdToTwd);
        $this->assertEquals(0, $zeroUSDToTwd);

        $this->assertEquals(0, $negativeTwdToTwd);
        $this->assertEquals(0, $negativeUSDToTwd);
    }

    public function testInvalidTransferToTWD()
    {
        $result = CurrencyFacade::toTWD('invalid', Currency::TWD);

        $this->assertFalse($result);
    }
}
