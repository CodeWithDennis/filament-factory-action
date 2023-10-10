<?php

namespace CodeWithDennis\FactoryAction\Commands;

use Illuminate\Console\Command;

class FactoryActionCommand extends Command
{
    public $signature = 'filament-factory-action';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
