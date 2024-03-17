<?php

namespace App\Controller;

use App\Exception\DataNotFoundException;
use App\Exception\InvalidJsonDataException;
use App\Model\CheckCurrencySuccessModel;
use App\Model\CurrencyModel;
use App\Model\Exception\DataNotFoundModel;
use App\Model\Exception\JsonDataInvalidModel;
use App\Model\ExchangeRateCurrencySuccessModel;
use App\Query\ExchangeRateCurrencyQuery;
use App\Repository\CurrencyRepository;
use App\Service\RequestServiceInterface;
use App\Tool\ResponseTool;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Response(
    response: 400,
    description: "JSON Data Invalid",
    content: new Model(type: JsonDataInvalidModel::class)
)]
#[OA\Response(
    response: 404,
    description: "Data not found",
    content: new Model(type: DataNotFoundModel::class)
)]
#[OA\Tag(name: "Currency")]
class CurrencyController extends AbstractController
{
    #[Route('/api/currency', name: 'checkCurrency', methods: ['GET'])]
    #[OA\Get(
        description: "Endpoint returning a list of currencies in system",
        requestBody: new OA\RequestBody(),
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new Model(type: CheckCurrencySuccessModel::class)
            )
        ]
    )]
    public function checkCurrency(
        CurrencyRepository $currencyRepository
    ): Response
    {
        $successModel = new CheckCurrencySuccessModel();

        foreach ($currencyRepository->findAll() as $currency) {
            $successModel->addCurrency(
                new CurrencyModel(
                    $currency->getId(),
                    $currency->getName(),
                    $currency->getCurrencyCode(),
                    $currency->getExchangeRate()
                )
            );
        }

        return ResponseTool::getResponse($successModel);
    }

    /**
     * @throws InvalidJsonDataException
     * @throws DataNotFoundException
     */
    #[Route('/api/currency', name: 'exchangeRateCurrency', methods: ['POST'])]
    #[OA\Post(
        description: "Endpoint returning a conversion of the exchange rate to given currency",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: ExchangeRateCurrencyQuery::class),
                type: "object"
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
                content: new Model(type: ExchangeRateCurrencySuccessModel::class)
            ),
        ]
    )]
    public function exchangeRateCurrency(
        Request                 $request,
        RequestServiceInterface $requestServiceInterface,
        CurrencyRepository      $currencyRepository
    ): Response
    {
        $exchangeRateCurrencyQuery = $requestServiceInterface->getRequestBodyContent($request, ExchangeRateCurrencyQuery::class);

        if ($exchangeRateCurrencyQuery instanceof ExchangeRateCurrencyQuery) {
            $currency = $currencyRepository->findOneBy([
                'currencyCode' => $exchangeRateCurrencyQuery->getCurrencyCode()
            ]);

            if ($currency === null) {
                throw new DataNotFoundException(["currency.dont.exist"]);
            }

            $amount = $exchangeRateCurrencyQuery->getExchangeAmount() * $currency->getExchangeRate();

            return ResponseTool::getResponse(new ExchangeRateCurrencySuccessModel($amount, $currency->getName()));
        }

        throw new InvalidJsonDataException("exchange.rate.invalid.query");
    }
}
