<?php

namespace App\Console\Commands\InstructionExecutor\FileFactory;

class ModelFIleFactory extends FileFactory
{
    protected function create(string $fileName, string $content): string
    {
        $modelsDirectory = app_path('Models');
        if (!file_exists($modelsDirectory)) {
            mkdir($modelsDirectory, 0777, true);
        }

        $modelName = ucfirst(mb_strtolower($fileName));
        $filePath = $modelsDirectory . '/' . $modelName . '.php';

        file_put_contents($filePath, $content);

        return $filePath;
    }
}
