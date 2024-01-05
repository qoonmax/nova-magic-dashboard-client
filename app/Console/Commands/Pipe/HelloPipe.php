<?php

namespace App\Console\Commands\Pipe;

use Illuminate\Http\Request;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;

class HelloPipe extends Pipe
{
    public function handle(Request $request, callable $next): Request
    {
        info('🧙  Welcome to the Nova Magic Dashboard generator!');

        note(
            message: 'This tool will create Laravel models, Nova resources, filters, lenses, menus based on your database structure. '
            . PHP_EOL . 'All you have to do is check it out.',
            type: 'info'
        );

        return $next($request);
    }
}
