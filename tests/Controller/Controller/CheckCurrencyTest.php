<?php

namespace App\Tests\Controller\CurrencyController;

use App\Repository\CurrencyRepository;
use App\Tests\AbstractWebTest;

class CheckCurrencyTest extends AbstractWebTest
{
    public function test_checkCurrencySuccess(): void
    {
        $currencyRepository = $this->getService(CurrencyRepository::class);

        $this->assertInstanceOf(CurrencyRepository::class, $currencyRepository);

        $exchangeRate = 1.8537;

        $this->databaseMockManager->testFunc_addCurrency("SDR (MFW)", "XDR", $exchangeRate);

        self::$webClient->request("GET", "/api/currency");

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(200);
        $response = self::$webClient->getResponse();

        $responseContent = json_decode($response->getContent(), true);
        /// step 5
        $this->assertIsArray($responseContent);

        $this->assertArrayHasKey("currencies", $responseContent);
        $this->assertCount(count($currencyRepository->findAll()), $responseContent["currencies"]);
    }
}