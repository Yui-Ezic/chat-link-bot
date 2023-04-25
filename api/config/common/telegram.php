<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use TelegramBot\Api\Client;
use function App\env;

return [
    Client::class =>  static fn (ContainerInterface $container): Client => new Client($container->get('config')['telegram']['token']),
    'config' => [
        'telegram' => [
            'token' => env('TELEGRAM_API_TOKEN'),
        ],
    ],
];