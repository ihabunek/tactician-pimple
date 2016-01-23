Tactician Pimple Locator
========================

Allows lazy loading of command handlers from a
[Pimple](http://pimple.sensiolabs.org/) dependency injection container.

[![Travis](https://img.shields.io/travis/ihabunek/tactician-pimple.svg?style=flat-square)](https://travis-ci.org/ihabunek/tactician-pimple)
[![Packagist](https://img.shields.io/packagist/v/bezdomni/tactician-pimple.svg?style=flat-square)](https://packagist.org/packages/bezdomni/tactician-pimple)
[![Packagist](https://img.shields.io/packagist/l/bezdomni/tactician-pimple.svg?style=flat-square)](https://github.com/ihabunek/tactician-pimple/blob/master/LICENSE)

## Install

Install via composer

```
composer require bezdomni/tactician-pimple
```

## Usage

Presuming you have a couple of commands: `UserAddCommand`, `UserDeleteCommand`,
and corresponding handlers `UserAddHandler`, `UserDeleteHandler`.

```php
use Bezdomni\Tactician\Pimple\PimpleLocator;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Pimple\Container;

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

```


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
