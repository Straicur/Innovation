<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetLatestCurrencyService implements GetLatestCurrencyServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getNewest(): array
    {
        $response = $this->client->request(
            'GET',
            'http://api.nbp.pl/api/exchangerates/tables/a/today?format=json'
        );

        return $response->toArray()[0]["rates"];
    }
}