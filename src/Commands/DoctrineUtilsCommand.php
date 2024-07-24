<?php

namespace Bullet\DoctrineUtils\Commands;

use Illuminate\Console\Command;

class DoctrineUtilsCommand extends Command
{
    public $signature = 'doctrine-utils';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
