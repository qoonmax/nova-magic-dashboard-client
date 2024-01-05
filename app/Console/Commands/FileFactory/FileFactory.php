<?php

namespace App\Console\Commands\FileFactory;

interface FileFactory
{
    public static function create(string $modelName, string $content): void;
}
