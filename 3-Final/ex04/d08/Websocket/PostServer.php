<?php

namespace App\Websocket;

use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Websocket\Server\WebsocketClientHandler;
use Amp\Websocket\WebsocketClient;

class PostServer implements WebsocketClientHandler
{
    private static array $clients = [];

    public static function broadcast(string $message): void
    {
        foreach (self::$clients as $client) {
            if (!$client->isClosed()) {
                $client->sendText($message);
            }
        }
    }

    public function handleClient(
        WebsocketClient $client,
        Request $request,
        Response $response
    ): void {
        $id = spl_object_id($client);
        self::$clients[$id] = $client;

        try {
            foreach ($client as $message) {
                // OPTIONAL: ignore incoming messages
            }
        } finally {
            unset(self::$clients[$id]);
        }
    }
}