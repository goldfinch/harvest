<?php

namespace Goldfinch\Harvest\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'vendor:harvest:config')]
class HarvestConfigCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:harvest:config';

    protected $description = 'Create Harvest YML config';

    protected $path = 'app/_config';

    protected $type = 'config';

    protected $stub = './stubs/config.stub';

    protected $extension = '.yml';
}
