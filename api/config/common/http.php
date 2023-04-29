<?php

declare(strict_types=1);

use App\Http\Action\Discord\WebhookAction;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use TelegramBot\Api\BotApi;

return [
    ResponseFactoryInterface::class => static fn (): ResponseFactoryInterface => new ResponseFactory(),
    WebhookAction::class => static fn (ContainerInterface $container): WebhookAction => new WebhookAction(
        $container->get(BotApi::class),
        $container->get(LoggerInterface::class),
        $container->get('config')['telegram']['chat_id']
    )
];
