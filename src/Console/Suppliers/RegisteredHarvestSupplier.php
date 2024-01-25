<?php

namespace Goldfinch\Harvest\Console\Suppliers;

use Goldfinch\Harvest\Harvest;
use Goldfinch\CLISupplier\CLISupplier;

class RegisteredHarvestSupplier implements CLISupplier
{
    public static function run(...$args)
    {
        $harvesters = Harvest::config();

        return $harvesters->get('harvesters');
    }
}
