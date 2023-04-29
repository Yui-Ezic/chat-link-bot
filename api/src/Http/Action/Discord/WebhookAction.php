<?php

namespace App\Http\Action\Discord;

use App\Http\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class WebhookAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly BotApi $telegram,
        private readonly LoggerInterface $logger,
        private readonly string $chatId,
    ) {
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Discord webhook called.', [
            'requestBody' => (string)$request->getBody()
        ]);
        $webhook = $request->getParsedBody();
        $message = $webhook['message'];
        if ($message['from'] === 'LinkChatsBot') {
            return new EmptyResponse(200);
        }
        $this->telegram->sendMessage($this->chatId, "{$message['from']}: {$message['text']}");
        return new EmptyResponse(200);
    }
}