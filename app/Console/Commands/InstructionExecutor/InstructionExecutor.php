<?php

namespace App\Console\Commands\InstructionExecutor;

readonly class InstructionExecutor
{
    public function __construct(
        private array       $instructions,
        private FIleFactory $modelFileFactory,
    )
    {}

    public function execute(): void
    {
        if ($this->instructions['for_creating']) {
            foreach ($this->instructions['for_creating'] as $instruction) {
                $this->modelFileFactory->create($instruction['path'], $instruction['content']);
            }
        }
    }
}
