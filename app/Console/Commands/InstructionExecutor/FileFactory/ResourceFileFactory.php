<?php

namespace App\Console\Commands\InstructionExecutor\FileFactory;

class ResourceFileFactory extends FileFactory
{
    protected function create(string $fileName, string $content): string
    {
        $resourcesDirectory = app_path('Nova');
        if (!file_exists($resourcesDirectory)) {
            mkdir($resourcesDirectory, 0777, true);
        }

        $modelName = ucfirst(mb_strtolower($fileName));
        $filePath = $resourcesDirectory . '/' . $modelName . '.php';

        file_put_contents($filePath, $content);

        return $filePath;
    }
}
