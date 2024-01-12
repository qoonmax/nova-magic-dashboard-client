<?php

namespace App\Console\Commands\Pipe;

use function Laravel\Prompts\text;

class PrivateKeyPipe extends Pipe
{
    public function handle(Context $context, callable $next): Context
    {
        //TODO: Move to config
        $defaultPrivateKey = env('NOVA_MAGIC_DASHBOARD_PRIVATE_KEY') ?? '';

        $privateKey = text(
            label: 'Enter your private key.',
            placeholder: 'xxxx-xxxx-xxxx-xxxx',
            default: $defaultPrivateKey,
            required: true,
            validate: fn(string $value) => match (true) {
                strlen($value) !== 19 => 'The private key must be 19 characters long.',
                default => null
            },
            hint: 'You can find the private key in your personal account. (https://nova.magic-dashboard.com/profile)'
        );

        $context->setPrivateKey($privateKey);

        return $next($context);
    }
}
