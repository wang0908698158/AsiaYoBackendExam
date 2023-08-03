<?php

namespace Tests\Unit;

use App\Http\Controllers\CurrencyController;
use App\Service\CurrencyService;
use PHPUnit\Framework\TestCase;

class ConvertCurrencyTest extends TestCase
{
    /**
     * 單元測試 CurrencyService convertCurrency
     */
    public function test_service_convert_currency(): void
    {
        $service = new CurrencyService;
        $response = $service->convertCurrency('USD', 'JPY', '$1,525', 2);

        $this->assertIsArray($response);

        $responseArray = [
            'msg' => 'success',
            'amount' => '$170,496.53'
        ];
        $this->assertEquals($response, $responseArray);
    }
}
