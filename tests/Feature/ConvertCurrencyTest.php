<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConvertCurrencyTest extends TestCase
{
    /**
     * 功能測試 - CurrencyController convertCurrency()
     */
    public function test_convert_currency(): void
    {
        $response = $this->getJson('/api/convertCurrency?source=USD&target=JPY&amount=$1,525');

        $response->assertStatus(200)
            ->assertJson([
                'msg' => 'success',
                'amount' => '$170,496.53'
            ]);
    }
}
