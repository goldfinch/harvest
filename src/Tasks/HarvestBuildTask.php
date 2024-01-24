<?php

namespace Goldfinch\Harvest\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;

class HarvestBuildTask extends BuildTask
{
    private static $segment = 'harvest';

    protected $enabled = true;

    protected $title = 'Harvest';

    protected $description = 'Run harvest';

    public function __construct()
    {
        if (!Director::is_cli()) {
            exit;
        }

        // run all existed harvests

        // shell_exec('php vendor/silverstripe/framework/cli-script.php dev/tasks/harvest');
    }

    public function run($request)
    {
        // ..
    }
}
