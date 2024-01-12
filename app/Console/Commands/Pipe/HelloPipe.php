<?php

namespace App\Console\Commands\Pipe;

use Illuminate\Http\Request;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;

class HelloPipe extends Pipe
{
    public function handle(Request $request, callable $next): Request
    {
        note(
            message: "🧙  <fg=cyan>Welcome to the Nova Magic Dashboard generator!</>",
            type: 'info'
        );

        return $next($request);
    }
}
