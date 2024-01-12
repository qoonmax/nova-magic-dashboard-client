<?php

namespace App\Console\Commands;

use App\Console\Commands\InstructionExecutor\FileFactory\ModelFIleFactory;
use App\Console\Commands\InstructionExecutor\FileFactory\ResourceFileFactory;
use App\Console\Commands\InstructionExecutor\InstructionExecutor;
use App\Console\Commands\Pipe\ClientEnvironmentPipe;
use App\Console\Commands\Pipe\Context;
use App\Console\Commands\Pipe\DatabasePipe;
use App\Console\Commands\Pipe\HelloPipe;
use App\Console\Commands\Pipe\ModelPipe;
use App\Console\Commands\Pipe\PrivateKeyPipe;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use function Laravel\Prompts\intro;
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
        $response = $client->post('https://webhook.site/b2c24ce5-0e28-499b-9307-88693fa8b52e', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' =>  $payload->getPrivateKey()
            ],
            'body' => json_encode([
                'client_environment' => $payload->getClientEnvironment(),
                'database' => [
                    'tables' => $payload->getTables(),
                ],
            ])
        ]);

        $instructions = json_decode($response->getBody()->getContents(), true);

        //mock instructions
        $instructions = [
            'models' => [
                [
                    'name' => 'Mock',
                    'content' => '<?php'
                ]
            ],
            'resources' => [
                [
                    'name' => 'Mock',
                    'content' => '<?php'
                ]
            ]
        ];

        $instructionExecutor = new InstructionExecutor(
            $instructions,
            new ModelFileFactory(),
            new ResourceFileFactory(),
        );
        $instructionExecutor->execute();

        outro("🧙  <fg=cyan>Completed!</>");
    }
}
