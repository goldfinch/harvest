<?php

namespace Goldfinch\Harvest\Console\Suppliers;

use Goldfinch\Harvest\Harvest;
use Goldfinch\CLISupplier\CLISupplier;

class HarvestSupplier implements CLISupplier
{
    public static function run(...$args)
    {
        if (count($args)) {
            $harvesters = Harvest::config()->get('harvesters');
            if ($harvesters && is_array($harvesters)) {
                $harvestClass = $harvesters[$args[0]];
                $harvestClass::run();
            }
        }
        return;
    }
}
