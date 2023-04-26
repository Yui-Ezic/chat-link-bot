<?php

namespace App\Http\Action\Telegram;

use App\Discord\Channel;
use App\Http\Response\PlainTextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\Client;
use TelegramBot\Api\Types\Update;
use Throwable;

class WebhookAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly Client $bot,
        private readonly Channel $discord,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->debug('Telegram webhook called.', [
            'requestBody' => (string)$request->getBody()
        ]);
        $this->bot->on(function (Update $update) {
            $message = $update->getMessage();
            if ($message) {
                $this->discord->sendMessage("{$message->getFrom()->getFirstName()}:  {$message->getText()}");
            }
        }, function () {
            return true;
        });
        $this->bot->run();
        return new PlainTextResponse('Ok');
    }
}