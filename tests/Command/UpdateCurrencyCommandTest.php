<?php

namespace App\Tests\Command;

use App\Repository\CurrencyRepository;
use App\Tests\AbstractKernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateCurrencyCommandTest extends AbstractKernelTestCase
{
    public function test_updateCurrencyCommandSuccess()
    {
        $currencyRepository = $this->getService(CurrencyRepository::class);

        $this->assertInstanceOf(CurrencyRepository::class, $currencyRepository);

        $cmd = $this->commandApplication->find("currency:update");

        $tester = new CommandTester($cmd);

        $tester->execute([]);

        $tester->assertCommandIsSuccessful();
    }
}
