<?php

namespace App\Console\Commands\Pipe;

use Illuminate\Http\Request;

abstract class Pipe
{
    abstract public function handle(Request $request, callable $next): Request;
}
