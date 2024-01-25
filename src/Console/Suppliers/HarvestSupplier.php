<?php

namespace Goldfinch\Harvest\Console\Suppliers;

use Goldfinch\Harvest\Harvest;
use Goldfinch\CLISupplier\CLISupplier;

class HarvestSupplier implements CLISupplier
{
    public static function run()
    {
        $harvesters = Harvest::config();

        return $harvesters->get('harvesters');
    }
}
