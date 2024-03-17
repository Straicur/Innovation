<?php

namespace App\Controller;

use App\Model\Exception\DataNotFoundModel;
use App\Model\Exception\JsonDataInvalidModel;
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
            )
        ]
    )]
    public function checkCurrency(): Response
    {
        return ResponseTool::getResponse();
    }

    #[Route('/api/currency', name: 'exchangeRateCurrency', methods: ['POST'])]
    #[OA\Post(
        description: "Endpoint returning a conversion of the exchange rate to given currency",
        requestBody: new OA\RequestBody(),
        responses: [
            new OA\Response(
                response: 200,
                description: "Success",
            ),
        ]
    )]
    public function exchangeRateCurrency(Request $request): Response
    {
        return ResponseTool::getResponse();
    }
}
