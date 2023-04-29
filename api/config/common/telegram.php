<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Client;
use function App\env;

return [
    Client::class => static fn (ContainerInterface $container): Client => new Client($container->get('config')['telegram']['token']),
    BotApi::class => static fn (ContainerInterface $container): BotApi => new BotApi($container->get('config')['telegram']['token']),
    'config' => [
        'telegram' => [
            'token' => env('TELEGRAM_API_TOKEN'),
            'chat_id' => env('TELEGRAM_CHAT_ID')
        ],
    ],
];