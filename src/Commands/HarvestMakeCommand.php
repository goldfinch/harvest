<?php

namespace Goldfinch\Harvest\Commands;

use Symfony\Component\Finder\Finder;
use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'make:harvest')]
class HarvestMakeCommand extends GeneratorCommand
{
    protected static $defaultName = 'make:harvest';

    protected $description = 'Create harvest [Harvest]';

    protected $path = '[psr4]/Harvest';

    protected $type = 'harvest';

    protected $stub = './stubs/harvest.stub';

    protected $prefix = 'Harvest';

    protected function execute($input, $output): int
    {
        $harvestName = $input->getArgument('name');
        $shortname = $input->getArgument('shortname');

        if (!$shortname) {
            $shortname = strtolower($harvestName);
        }

        $harvestName = 'App\Harvest\\' . $harvestName . $this->prefix; // TODO

        if (!$this->setHarvestInConfig($harvestName, $shortname)) {
            // create config

            $command = $this->getApplication()->find('vendor:harvest:config');

            $arguments = [
                'name' => 'harvest',
            ];

            $greetInput = new ArrayInput($arguments);
            $returnCode = $command->run($greetInput, $output);

            $this->setHarvestInConfig($harvestName, $shortname);
        }

        parent::execute($input, $output);

        return Command::SUCCESS;
    }

    private function setHarvestInConfig($harvestName, $shortname)
    {
        $rewritten = false;

        $finder = new Finder();
        $files = $finder->in(BASE_PATH . '/app/_config')->files()->contains('Goldfinch\Harvest\Harvest:');

        foreach ($files as $file) {

            // stop after first replacement
            if ($rewritten) {
                break;
            }

            if (strpos($file->getContents(), 'harvesters') !== false) {

                $ucfirst = ucfirst($harvestName);

                if ($shortname) {
                    $harvestLine = $shortname.': '.$harvestName;
                } else {
                    // not reachable at the moment as we modifying $shortname if it's not presented
                    $harvestLine = '- ' . $harvestName;
                }

                $newContent = $this->addToLine(
                    $file->getPathname(),
                    'harvesters:','    '.$harvestLine,
                );

                file_put_contents($file->getPathname(), $newContent);

                $rewritten = true;
            }
        }

        return $rewritten;
    }

    public function configure(): void
    {
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'The name class of the ' . strtolower($this->type)
       );

       $this->addArgument(
            'shortname',
            InputArgument::OPTIONAL,
       );
    }
}
