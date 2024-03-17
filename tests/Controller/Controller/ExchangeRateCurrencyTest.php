<?php

namespace App\Tests\Controller\CurrencyController;

use App\Repository\CurrencyRepository;
use App\Tests\AbstractWebTest;

class ExchangeRateCurrencyTest extends AbstractWebTest
{
    public function test_exchangeRateCurrencySuccess(): void
    {
        $currencyRepository = $this->getService(CurrencyRepository::class);

        $this->assertInstanceOf(CurrencyRepository::class, $currencyRepository);

        $this->databaseMockManager->testFunc_addCurrency("SDR (MFW)", "XDR", 1.8537);

        $content = [
            "exchangeAmount" => 100.32,
            "currencyCode" => "XDR",
        ];

        self::$webClient->request("POST", "/api/currency", content: json_encode($content));

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(200);
        $response = self::$webClient->getResponse();

        $responseContent = json_decode($response->getContent(), true);
        /// step 5
        $this->assertIsArray($responseContent);

        $this->assertArrayHasKey("exchangeRate", $responseContent);
        $this->assertArrayHasKey("exchangeName", $responseContent);

        $this->assertSame(185.96318399999998, $responseContent["exchangeRate"]);
    }

    public function test_exchangeRateCurrencyBadRequest(): void
    {
        $currencyRepository = $this->getService(CurrencyRepository::class);

        $this->assertInstanceOf(CurrencyRepository::class, $currencyRepository);

        $this->databaseMockManager->testFunc_addCurrency("SDR (MFW)", "XDR", 1.8537);

        $content = [
            "exchangeAmount" => 100.32
        ];

        self::$webClient->request("POST", "/api/currency", content: json_encode($content));
        self::assertResponseStatusCodeSame(400);

        $responseContent = self::$webClient->getResponse()->getContent();

        $this->assertNotNull($responseContent);
        $this->assertNotEmpty($responseContent);
        $this->assertJson($responseContent);

        $responseContent = json_decode($responseContent, true);

        $this->assertIsArray($responseContent);
        $this->assertArrayHasKey("error", $responseContent);
    }

    public function test_exchangeRateCurrencyIncorrectCurrencyCode(): void
    {
        $currencyRepository = $this->getService(CurrencyRepository::class);

        $this->assertInstanceOf(CurrencyRepository::class, $currencyRepository);

        $this->databaseMockManager->testFunc_addCurrency("SDR (MFW)", "XDR", 1.8537);

        $content = [
            "exchangeAmount" => 100.32,
            "currencyCode" => "XDI",
        ];

        self::$webClient->request("POST", "/api/currency", content: json_encode($content));

        self::assertResponseStatusCodeSame(404);

        $responseContent = self::$webClient->getResponse()->getContent();

        $this->assertNotNull($responseContent);
        $this->assertNotEmpty($responseContent);
        $this->assertJson($responseContent);

        $responseContent = json_decode($responseContent, true);

        $this->assertIsArray($responseContent);
        $this->assertArrayHasKey("error", $responseContent);
        $this->assertArrayHasKey("data", $responseContent);
    }
}