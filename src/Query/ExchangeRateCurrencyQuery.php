<?php

namespace App\Query;

use Symfony\Component\Validator\Constraints as Assert;

class ExchangeRateCurrencyQuery
{
    #[Assert\NotNull(message: "ExchangeAmount is null")]
    #[Assert\NotBlank(message: "ExchangeAmount is empty")]
    #[Assert\Type(type: "float")]
    private float $exchangeAmount;

    #[Assert\NotNull(message: "CurrencyCode is null")]
    #[Assert\NotBlank(message: "CurrencyCode is empty")]
    #[Assert\Type(type: "string")]
    private string $currencyCode;

    public function getExchangeAmount(): float
    {
        return $this->exchangeAmount;
    }

    public function setExchangeAmount(float $exchangeAmount): void
    {
        $this->exchangeAmount = $exchangeAmount;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

}