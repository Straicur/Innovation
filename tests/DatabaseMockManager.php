<?php

namespace App\Tests;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabaseMockManager
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getService(string $serviceName): object
    {
        return $this->kernel->getContainer()->get($serviceName);
    }

    public function testFunc_addCurrency(string $name, string $currencyCode, float $exchangeRate): Currency
    {
        $currencyRepositoryRepository = $this->getService(CurrencyRepository::class);

        $newCurrency = new Currency($name, $currencyCode, $exchangeRate);

        $currencyRepositoryRepository->save($newCurrency);

        return $newCurrency;
    }
}