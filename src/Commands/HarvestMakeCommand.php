<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\Taz\Services\InputOutput;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;

#[AsCommand(name: 'make:harvest')]
class HarvestMakeCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:harvest';

    protected $description = 'Create harvest [Harvest]';

    protected $path = '[psr4]/Harvest';

    protected $type = 'harvest';

    protected $stub = './stubs/harvest.stub';

    protected $suffix = 'Harvest';

    protected function execute($input, $output): int
    {
        $state = parent::execute($input, $output);

        if ($state === false) {
            return Command::FAILURE;
        }

        $nameInput = $this->getAttrName($input);

        $shortName = $this->askClassNameQuestion('What [short name] this harvest need to be called by? (eg: ' . strtolower($nameInput) . ')', $input, $output, '/^([A-z0-9\_-]+)$/', 'Name can contains letter, numbers, underscore and dash');

        // find config
        $config = $this->findYamlConfigFileByName('app-harvest');

        // create new config if not exists
        if (!$config) {

            $command = $this->getApplication()->find('make:config');
            $command->run(new ArrayInput([
                'name' => 'harvest',
                '--plain' => true,
                '--after' => 'goldfinch/harvest',
                '--nameprefix' => 'app-',
            ]), $output);

            $config = $this->findYamlConfigFileByName('app-harvest');
        }

        // update config
        $this->updateYamlConfig(
            $config,
            'Goldfinch\Harvest\Harvest' . '.harvesters.' . $shortName,
            $this->getNamespaceClass($input)
        );

        if ($state !== false) {
            $io = new InputOutput($input, $output);
            $io->info('To refresh harvest list [php taz harvest] you need to run [php taz dev/build]');
        }

        return Command::SUCCESS;
    }
}
