<?php

declare(strict_types=1);

use App\Http;
use Slim\App;

return static function (App $app): void {
    $app->get('/', Http\Action\HomeAction::class);
    $app->post('/telegram', Http\Action\Telegram\WebhookAction::class);
};
