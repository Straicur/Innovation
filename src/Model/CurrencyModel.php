<?php

namespace App\Model;

class CurrencyModel
{
    private string $id;
    private string $name;
    private string $currencyCode;
    private float $exchangeRate;

    /**
     * @param string $id
     * @param string $name
     * @param string $currencyCode
     * @param float $exchangeRate
     */
    public function __construct(string $id, string $name, string $currencyCode, float $exchangeRate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currencyCode = $currencyCode;
        $this->exchangeRate = $exchangeRate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }
}