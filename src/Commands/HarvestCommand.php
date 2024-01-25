<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\Harvest\Harvest;
use SilverStripe\Control\Director;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'harvest')]
class HarvestCommand extends GeneratorCommand
{
    protected static $defaultName = 'harvest';

    protected $description = 'Display available harvesters or call one';

    protected function execute($input, $output): int
    {
        // $response = shell_exec(
        //     'php vendor/silverstripe/framework/cli-script.php dev/cli-supplier',
        // );

        // dd(json_decode($response));

        return Command::SUCCESS;
    }
}
