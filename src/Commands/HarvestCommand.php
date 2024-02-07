<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\CLISupplier\SupplyHelper;
use Goldfinch\Taz\Services\InputOutput;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'harvest')]
class HarvestCommand extends GeneratorCommand
{
    protected static $defaultName = 'harvest';

    protected $description = 'Display available harvesters or call one';

    protected $no_arguments = true;

    protected function execute($input, $output): int
    {
        $harvest = $input->getArgument('harvest');

        $response = SupplyHelper::supply('harvest');

        if ($response && is_array($response)) {
            if ($harvest) {
                $io = new InputOutput($input, $output);

                if (isset($response[$harvest])) {
                    // run harvest
                    SupplyHelper::supply('harvest-run', $harvest);
                    $io->right('The Harvest [' . $harvest . '] has been run');
                } else {
                    $io->wrong('The Harvest [' . $harvest . '] does not exist. Run [php taz harvest] to discover all available harvesters. If you just created a new Harvest, you might need to run [php taz dev/build] to refresh the list');
                }
            } else {

                $list = [];

                foreach ($response as $key => $item) {
                    $list[] = [$key, $item];
                }
                $table = new Table($output);
                $table
                    ->setHeaders(['Shortname', 'Class'])
                    ->setRows($list)
                ;
                $table->render();
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
