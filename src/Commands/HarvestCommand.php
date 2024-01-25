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
                    $io->right('The harvest [' . $harvest . '] has been run');
                } else {
                    $io->wrong('Harvest [' . $harvest . '] does not exists. Run [php taz harvest] to discover all available harvesters');
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

    public function configure(): void
    {
       $this->addArgument(
            'harvest',
            InputArgument::OPTIONAL,
       );
    }
}
