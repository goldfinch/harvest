<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\CLISupplier\SupplyHelper;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'harvest:all')]
class HarvestAllCommand extends GeneratorCommand
{
    protected static $defaultName = 'harvest:all';

    protected $description = 'Run all available harvesters';

    protected $no_arguments = true;

    protected function execute($input, $output): int
    {
        $response = SupplyHelper::supply('harvest');

        if ($response && is_array($response)) {

            foreach ($response as $harvest => $class) {

                $command = $this->getApplication()->find('harvest');

                $arguments = [
                    'harvest' => $harvest,
                ];

                $greetInput = new ArrayInput($arguments);
                $returnCode = $command->run($greetInput, $output);
            }
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->setDescription($this->description)
            ->setHelp($this->help);

       $this->addArgument(
            'harvest',
            InputArgument::OPTIONAL,
       );
    }
}
