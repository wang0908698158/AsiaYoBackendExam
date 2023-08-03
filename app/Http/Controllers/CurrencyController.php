<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Service\CurrencyService;
use Exception;

class CurrencyController extends BaseController
{
    /**
     * 匯率轉換
     *
     * @param  Request $request
     * @param  CurrencyService $currencyService
     * @return void
     */
    public function convertCurrency(Request $request, CurrencyService $currencyService)
    {
        # 檢查參數是否缺少
        if (!$request->source || !$request->target || !$request->amount) {
            throw new Exception('loss parameter');
        }
        # 轉換幣別
        $result = $currencyService->convertCurrency($request->source, $request->target, $request->amount, 2);

        return response()->json($result);
    }
}
