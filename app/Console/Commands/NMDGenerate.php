<?php

namespace App\Console\Commands;

use App\Console\Commands\InstructionExecutor\FileFactory\ResourceFileFactory;
use App\Console\Commands\InstructionExecutor\InstructionExecutor;
use App\Console\Commands\InstructionExecutor\FIleFactory;
use App\Console\Commands\Pipe\ClientEnvironmentPipe;
use App\Console\Commands\Pipe\Context;
use App\Console\Commands\Pipe\DatabasePipe;
use App\Console\Commands\Pipe\HelloPipe;
use App\Console\Commands\Pipe\ModelPipe;
use App\Console\Commands\Pipe\PrivateKeyPipe;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use function Laravel\Prompts\outro;

class NMDGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magic:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $context = new Context();

        $payload = app(Pipeline::class)
            ->send($context)
            ->through([
                HelloPipe::class,
                ModelPipe::class,
                ClientEnvironmentPipe::class,
                PrivateKeyPipe::class,
                DatabasePipe::class
            ])->thenReturn();

        $client = new \GuzzleHttp\Client();
        $response = $client->post('http://nova-magic-dashboard-backend:8080/api/v1/generate', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $payload->getPrivateKey()
            ],
            'body' => json_encode([
                'client_environment' => $payload->getClientEnvironment(),
                'database' => [
                    'tables' => $payload->getTables(),
                ],
            ])
        ]);

        $instructions = json_decode($response->getBody()->getContents(), true);

        $instructionExecutor = new InstructionExecutor(
            $instructions,
            new FIleFactory()
        );
        $instructionExecutor->execute();

        outro("🧙  <fg=cyan>Completed!</>");
    }
}
