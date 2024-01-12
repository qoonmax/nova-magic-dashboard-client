<?php

namespace App\Console\Commands\Pipe;

abstract class Pipe
{
    abstract public function handle(Context $context, callable $next): Context;
}
