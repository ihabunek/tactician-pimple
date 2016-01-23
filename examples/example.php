<?php

use Bezdomni\Tactician\Pimple\PimpleLocator;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Pimple\Container;

require __DIR__ . '/../vendor/autoload.php';

// Add some test commands and handlers
require __DIR__ . '/models.php';

// Create a container and configure the handlers on it
$container = new Container();
$container['handlers.user.add'] = function () {
    echo "Creating AddUserHandler\n";
    return new AddUserHandler();
};
$container['handlers.user.delete'] = function () {
    echo "Creating DeleteUserHandler\n";
    return new DeleteUserHandler();
};

// Map command class names to container keys holding corresponding handlers
$locatorMap = [
    AddUserCommand::class => 'handlers.user.add',
    DeleteUserCommand::class => 'handlers.user.delete',
];

// Create the locator
$locator = new PimpleLocator($container, $locatorMap);

// Create a command handler middleware using the pimple locator
$middleware = new CommandHandlerMiddleware(
    new ClassNameExtractor(),
    $locator,
    new HandleInflector()
);

// Create the command bus using the middleware, and you're ready to go
$commandBus = new CommandBus([$middleware]);

// Create and run commands on the command bus
$addUserCommand = new AddUserCommand();
$deleteUserCommand = new DeleteUserCommand();

$commandBus->handle($addUserCommand);
$commandBus->handle($deleteUserCommand);
