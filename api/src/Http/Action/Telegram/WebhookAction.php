<?php

namespace App\Http\Action\Telegram;

use App\Http\Response\PlainTextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;
use Throwable;

class WebhookAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Client $bot
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bot->on(function (Update $update) {
            $message = $update->getMessage();
            $id = $message->getChat()->getId();
            $this->bot->sendMessage($id, 'Your message: ' . $message->getText());
        }, function () {
            return true;
        });
        $this->bot->run();
        return new PlainTextResponse('Ok');
    }
}