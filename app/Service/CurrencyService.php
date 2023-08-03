<?php

namespace App\Service;

class CurrencyService
{
    const CONVERT_CURRENCY_STATUS_SUCCESS = 'success';
    const CONVERT_CURRENCY_OUTPUT_MSG = 'msg';
    const CONVERT_CURRENCY_OUTPUT_AMOUNT = 'amount';

    /**
     * 匯率轉換
     *
     * @param  string $sourceCurrency
     * @param  string $targetCurrency
     * @param  string $sourceAmount
     * @param  int $decimal
     * @return array
     */
    public function convertCurrency(string $sourceCurrency, string $targetCurrency, string $sourceAmount, int $decimal = 0): array
    {
        $result = [];

        # 留下數字部分並轉為float
        $amount = (float)preg_replace('/[^0-9.]/', '', $sourceAmount);
        # 計算幣值轉換
        $convertAmount = $this->calCurrencyValue($sourceCurrency, $targetCurrency, $amount);

        # 計算目標幣值失敗 回傳錯誤訊息
        if ($convertAmount === null) {
            $result[self::CONVERT_CURRENCY_OUTPUT_MSG] = 'cal amount failed';
            return $result;
        }

        # 轉換成要回傳的幣值格式
        $targetAmount = '$' . number_format(
            $convertAmount,
            $decimal,
            '.',
            ','
        );

        $result = [
            self::CONVERT_CURRENCY_OUTPUT_MSG => self::CONVERT_CURRENCY_STATUS_SUCCESS,
            self::CONVERT_CURRENCY_OUTPUT_AMOUNT => $targetAmount
        ];

        return $result;
    }


    /**
     * 轉換幣值的功能
     *
     * @param  string $sourceCurrency
     * @param  string $targetCurrency
     * @param  float $sourceAmount
     * @return float|null
     */
    public function calCurrencyValue(string $sourceCurrency, string $targetCurrency, float $sourceAmount): ?float
    {
        $result = null;
        # 取得所有幣別對應
        $currencies = json_decode($this->getAllCurrencyData(), true);

        if (!isset($currencies['currencies'][$sourceCurrency]) || !isset($currencies['currencies'][$targetCurrency])) {
            return $result;
        }

        $result = $sourceAmount * $currencies['currencies'][$sourceCurrency][$targetCurrency];

        return $result;
    }


    /**
     * 匯率資料先暫時直接回傳json格式
     *
     * @return string
     */
    private function getAllCurrencyData(): string
    {
        $allCurrencyData = '{
            "currencies": {
            "TWD": {
            "TWD": 1,
            "JPY": 3.669,
            "USD": 0.03281
            },
            "JPY": {
            "TWD": 0.26956,
            "JPY": 1,
            "USD": 0.00885
            },
            "USD": {
            "TWD": 30.444,
            "JPY": 111.801,
            "USD": 1
            }
            }
            }';

        return $allCurrencyData;
    }
}
