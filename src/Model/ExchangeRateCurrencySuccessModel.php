<?php

namespace App\Model;

class ExchangeRateCurrencySuccessModel implements ModelInterface
{
    private float $exchangeRate;
    private string $exchangeName;

    /**
     * @param float $exchangeRate
     * @param string $exchangeName
     */
    public function __construct(float $exchangeRate, string $exchangeName)
    {
        $this->exchangeRate = $exchangeRate;
        $this->exchangeName = $exchangeName;
    }

    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }

    public function getExchangeName(): string
    {
        return $this->exchangeName;
    }

    public function setExchangeName(string $exchangeName): void
    {
        $this->exchangeName = $exchangeName;
    }

}