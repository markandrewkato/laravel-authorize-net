<?php

namespace Markandrewkato\AuthorizeNet\Commands;

use Illuminate\Console\Command;

class AuthorizeNetCommand extends Command
{
    public $signature = 'laravel-authorize-net';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
