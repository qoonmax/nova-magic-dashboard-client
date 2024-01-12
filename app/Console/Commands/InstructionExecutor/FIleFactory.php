<?php

namespace App\Console\Commands\InstructionExecutor;

use Laravel\Prompts\Output\ConsoleOutput;

class FIleFactory
{
    public function create(string $path, string $content): string
    {
        $filePath = base_path() . '/' . $path;
        file_put_contents($filePath, $content);

        $this->log($filePath);

        return $filePath;
    }

    private function log(string $path): void
    {
        $output = new ConsoleOutput();
        $output->writeln(' <fg=white>Created file: ' . $path . '</>');
    }
}
