<?php


namespace Ait\ArtisanTeleport\Console;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    use Concerns\ModifiesDefaultParams;

    public function __construct()
    {
        // if we have a signature prefix in config then we will normalize
        // the signature or the name to reflect that prefix
        $this->normalizeSignature();

        parent::__construct();

        $this->addNamespaceArgument();
    }
}
