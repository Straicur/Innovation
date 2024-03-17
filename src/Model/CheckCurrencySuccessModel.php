<?php

namespace App\Model;

class CheckCurrencySuccessModel implements ModelInterface
{
    /**
     * @var CurrencyModel[]
     */
    private array $currencies = [];

    /**
     * @return CurrencyModel[]
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function addCurrency(CurrencyModel $currency)
    {
        $this->currencies[] = $currency;
    }
}