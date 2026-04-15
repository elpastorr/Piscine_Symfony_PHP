<?php

namespace App\Command;

use Amp\Http\Server\DefaultErrorHandler;
use Amp\Http\Server\Router;
use Amp\Http\Server\SocketHttpServer;
use Amp\Socket\InternetAddress;
use Amp\Websocket\Server\Websocket;
use App\Websocket\PostServer;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'websocket:server',
    description: 'Start the WebSocket server on port 8080'
)]
class WebsocketServerCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting WebSocket server on port 8080...');

        $logger  = new NullLogger();
        $server  = SocketHttpServer::createForDirectAccess($logger);
        $server->expose(new InternetAddress('0.0.0.0', 8080));

        $errorHandler = new DefaultErrorHandler();
        $handler      = new PostServer();
        $websocket    = new Websocket($server, $logger, $handler);

        $router = new Router($server, $logger, $errorHandler);
        $router->addRoute('GET', '/', $websocket);

        $server->start($router, $errorHandler);

        $output->writeln('WebSocket server running on ws://127.0.0.1:8080');
        $output->writeln('Press Ctrl+C to stop.');

        \Amp\trapSignal([SIGINT, SIGTERM]);

        $server->stop();

        return Command::SUCCESS;
    }
}