<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'make:harvest')]
class HarvestMakeCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:harvest';

    protected $description = 'Create harvest [Harvest]';

    protected $path = '[psr4]/Harvesters';

    protected $type = 'harvest';

    protected $stub = './stubs/harvest.stub';

    protected $prefix = 'Harvest';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}
