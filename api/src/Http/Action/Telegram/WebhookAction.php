<?php

namespace App\Http\Action\Telegram;

use App\Http\Response\PlainTextResponse;
use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Channel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;
use Throwable;

class WebhookAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Client $bot,
        private readonly Channel $discord,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->bot->on(function (Update $update) {
            $message = $update->getMessage();
            $this->discord->sendMessage(
                MessageBuilder::new()
                    ->setContent("{$message->getFrom()->getFirstName()}:  {$message->getText()}")
            );
        }, function () {
            return true;
        });
        $this->bot->run();
        return new PlainTextResponse('Ok');
    }
}