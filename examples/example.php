<?php

require __DIR__ . '/../vendor/autoload.php';

// Create a command and corresponding handler

class TestCommand
{

}

class TestHandler
{
    public function handle(TestCommand $command)
    {
        // Clever code goes here
    }
}

// Create a DI container and mount the test handler

$container = new Pimple\Container();

$container['test_handler'] = function () {
    echo "Creating a handler\n";
    return new TestHandler();
};

// Create the locator and define the mapping between command class names and
// the DI container keys containing the handler.

$locator = new League\Tactician\Pimple\PimpleLocator($container, [
    TestCommand::class => 'test_handler'
]);


// Create a command and handle it

echo "Creating a command\n";
$command = new TestCommand();

echo "Finding a handler\n";
$handler = $locator->getHandlerForCommand(TestCommand::class);

echo "Calling the handler\n";
$handler->handle($command);

/*
 * Output:
 *     Creating a command
 *     Finding a handler
 *     Creating a handler
 *     Calling the handler
 *
 * i.e. the handler is created lazily
 */