<?php

namespace App\Console\Commands\Pipe;

class Context
{
    private array $clientEnvironment;
    private string $privateKey;
    private array $tables;

    public function getClientEnvironment(): array
    {
        return $this->clientEnvironment;
    }

    public function setClientEnvironment(array $clientEnvironment): Context
    {
        $this->clientEnvironment = $clientEnvironment;
        return $this;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function setPrivateKey(string $privateKey): Context
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    public function getTables(): array
    {
        return $this->tables;
    }

    public function setTables(array $tables): Context
    {
        $this->tables = $tables;
        return $this;
    }
}
