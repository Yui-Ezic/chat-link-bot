<?php

namespace App\Discord;

use GuzzleHttp\Client;

class Channel
{
    public function __construct(
        private Client $client,
        private string $token,
        private string $channelId
    ){
    }

    public function sendMessage(string $content): void
    {
        $this->client->post("https://discordapp.com/api/channels/$this->channelId/messages", [
            'headers' => [
                'Authorization' => 'Bot ' . $this->token,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'content' => $content
            ]
        ]);
    }
}