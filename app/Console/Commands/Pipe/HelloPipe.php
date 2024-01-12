<?php

namespace App\Console\Commands\Pipe;

use function Laravel\Prompts\note;

class HelloPipe extends Pipe
{
    public function handle(Context $context, callable $next): Context
    {
        note(
            message: "🧙  <fg=cyan>Welcome to the Nova Magic Dashboard generator!</>",
            type: 'info'
        );

        return $next($context);
    }
}
