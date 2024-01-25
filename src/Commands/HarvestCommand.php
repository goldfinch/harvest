<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\CLISupplier\SupplyHelper;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'harvest')]
class HarvestCommand extends GeneratorCommand
{
    protected static $defaultName = 'harvest';

    protected $description = 'Display available harvesters or call one';

    protected function execute($input, $output): int
    {
        $response = SupplyHelper::supply('harvest');

        // dd($response);

        return Command::SUCCESS;
    }
}
