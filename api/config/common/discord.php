<?php

declare(strict_types=1);

use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\WebSockets\Intents;
use Psr\Container\ContainerInterface;
use function App\env;

return [
    Discord::class =>  static fn (ContainerInterface $container): Discord => new Discord([
        'token' => $container->get('config')['discord']['token'],
        'intents' => Intents::getDefaultIntents()
    ]),
    Channel::class =>  static function (ContainerInterface $container): Channel {
        /** @var Discord $discord */
        $discord = $container->get(Discord::class);
        $guilds = $discord->guilds->get('id', $container->get('config')['discord']['guild_id']);
        return $guilds->channels->get('id', $container->get('config')['discord']['channel_id']);
    },
    'config' => [
        'discord' => [
            'token' => env('DISCORD_API_TOKEN'),
            'guild_id' => env('DISCORD_GUILD_ID'),
            'channel_id' => env('DISCORD_CHANNEL_ID')
        ],
    ],
];