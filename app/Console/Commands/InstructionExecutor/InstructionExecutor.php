<?php

namespace App\Console\Commands\InstructionExecutor;

use App\Console\Commands\InstructionExecutor\FileFactory\ModelFileFactory;
use App\Console\Commands\InstructionExecutor\FileFactory\ResourceFileFactory;

readonly class InstructionExecutor
{
    public function __construct(
        private array $instructions,
        private ModelFileFactory $modelFileFactory,
        private ResourceFileFactory $resourceFileFactory
    )
    {}

    public function execute(): void
    {
        if ($this->instructions['models']) {
            foreach ($this->instructions['models'] as $model) {
                $this->modelFileFactory->createAndLog($model['name'], $model['content']);
            }
        }

        if ($this->instructions['resources']) {
            foreach ($this->instructions['resources'] as $resource) {
                $this->resourceFileFactory->createAndLog($resource['name'], $resource['content']);
            }
        }
    }
}
