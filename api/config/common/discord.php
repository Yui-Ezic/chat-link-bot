<?php

declare(strict_types=1);

use App\Discord\Channel;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use function App\env;

return [
    Channel::class =>  static function (ContainerInterface $container): Channel {
        return new Channel(
            new Client(),
            $container->get('config')['discord']['token'],
            $container->get('config')['discord']['channel_id'],
        );
    },
    'config' => [
        'discord' => [
            'token' => env('DISCORD_API_TOKEN'),
            'channel_id' => env('DISCORD_CHANNEL_ID')
        ],
    ],
];