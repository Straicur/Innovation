<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

interface ResponseExceptionInterface
{
    public function getResponse(): Response;
}