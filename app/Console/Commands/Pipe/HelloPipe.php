<?php

namespace App\Console\Commands\Pipe;

use function Laravel\Prompts\intro;


class HelloPipe extends Pipe
{
    public function handle(Context $context, callable $next): Context
    {
        intro("🧙  <fg=cyan>Welcome to the Nova Magic Dashboard generator!</>");

        return $next($context);
    }
}
