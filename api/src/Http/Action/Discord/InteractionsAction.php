<?php

namespace App\Http\Action\Discord;

use App\Http\Response\EmptyResponse;
use App\Http\Response\JsonResponse;
use App\Http\Response\PlainTextResponse;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class InteractionsAction implements RequestHandlerInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Discord interaction called.', [
            'requestBody' => (string)$request->getBody()
        ]);
        $interaction = $request->getParsedBody();
        return match ($interaction['type']) {
            // InteractionType::Ping
            1 => new JsonResponse([
                'type' => 1
            ]),
            // InteractionType::ApplicationCommand
            2 => new JsonResponse([
                'type' => 2
            ]),
            default => new EmptyResponse(400),
        };
    }
}