<?php

namespace App\Service;

interface GetLatestCurrencyServiceInterface
{
    public function getNewest(): array;
}