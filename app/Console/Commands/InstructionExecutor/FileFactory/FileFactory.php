<?php

namespace App\Console\Commands\InstructionExecutor\FileFactory;

use Laravel\Prompts\Output\ConsoleOutput;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\note;

abstract class FileFactory
{
    public final function createAndLog(string $fileName, string $content): void
    {
        $path = $this->create($fileName, $content);
        $this->log($path);
    }
    protected abstract function create(string $fileName, string $content): string;

    private function log(string $path): void
    {
        $output = new ConsoleOutput();
        $output->writeln(' <fg=white>Created file: ' . $path . '</>');
    }
}
