<?php

namespace App\Http\Action\Discord;

use App\Http\Response\PlainTextResponse;
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logger->info('Discord interaction called.', [
            'requestBody' => (string)$request->getBody()
        ]);
        return new PlainTextResponse('Ok');
    }
}