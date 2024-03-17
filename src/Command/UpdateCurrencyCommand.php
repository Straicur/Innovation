<?php

namespace App\Command;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Service\GetLatestCurrencyService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'currency:update',
    description: 'Update currency with today data',
)]
class UpdateCurrencyCommand extends Command
{
    public function __construct(
        private readonly CurrencyRepository       $currencyRepository,
        private readonly GetLatestCurrencyService $currencyService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->info('Downloading currency data');

        try {
            $currencies = $this->currencyService->getNewest();
        } catch (Throwable $exception) {
            $io->error('Exception occurred ' . $exception->getMessage());
            return Command::FAILURE;
        }

        foreach ($currencies as $currency) {
            $currentCurrency = $this->currencyRepository->findOneBy([
                "name" => $currency["currency"]
            ]);

            if ($currentCurrency !== null) {
                $currentCurrency->setExchangeRate($currency["mid"]);
            } else {
                $currentCurrency = new Currency($currency["currency"], $currency["code"], $currency["mid"]);
            }

            $this->currencyRepository->save($currentCurrency);
        }

        $io->success('Successful update');

        return Command::SUCCESS;
    }
}