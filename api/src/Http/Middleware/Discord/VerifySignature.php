<?php

namespace App\Http\Middleware\Discord;

use App\Http\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SodiumException;

class VerifySignature implements MiddlewareInterface
{
    public function __construct(
        private readonly string $publicKey
    ){
    }

    /**
     * @throws SodiumException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->verify($request)) {
            return new EmptyResponse(401);
        }
        return $handler->handle($request);
    }

    /**
     * @throws SodiumException
     */
    private function verify(ServerRequestInterface $request): bool
    {
        $binarySignature = sodium_hex2bin($request->getHeaderLine('X-Signature-Ed25519'));
        $binaryKey = sodium_hex2bin($this->publicKey);
        $message = $request->getHeaderLine('X-Signature-Timestamp') . $request->getBody();
        return sodium_crypto_sign_verify_detached($binarySignature, $message, $binaryKey);
    }
}