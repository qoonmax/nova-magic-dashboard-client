<?php

namespace App\Console\Commands\FileFactory;

class ModelFIleFactory implements FileFactory
{
    public static function create(string $modelName, string $content): void
    {
        $modelsDirectory = app_path('Models');
        if (!file_exists($modelsDirectory)) {
            mkdir($modelsDirectory, 0777, true);
        }

        $modelName = ucfirst(mb_strtolower($modelName));
        $filePath = $modelsDirectory . '/' . $modelName . '.php';

        file_put_contents($filePath, $content);
    }
}
