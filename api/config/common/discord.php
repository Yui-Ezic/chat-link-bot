<?php

declare(strict_types=1);

use App\Discord\Channel;
use App\Http\Middleware\Discord\VerifySignature;
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
    VerifySignature::class => static function (ContainerInterface $container): VerifySignature {
        return new VerifySignature(
            $container->get('config')['discord']['public_id']
        );
    },
    'config' => [
        'discord' => [
            'token' => env('DISCORD_API_TOKEN'),
            'channel_id' => env('DISCORD_CHANNEL_ID'),
            'public_id' => env('DISCORD_PUBLIC_KEY'),
        ],
    ],
];