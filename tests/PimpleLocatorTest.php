<?php

namespace League\Tactician\Pimple\Tests;

use Bezdomni\Tactician\Pimple\PimpleLocator;

use League\Tactician\Tests\Fixtures\Command\AddTaskCommand;
use League\Tactician\Tests\Fixtures\Command\CompleteTaskCommand;

use stdClass;
use Pimple\Container;

class InMemoryLocatorTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicUsage()
    {
        $addCommandName = AddTaskCommand::class;
        $addHandlerKey = "add_handler";
        $addHandler = new stdClass;

        $completeCommandName = CompleteTaskCommand::class;
        $completeHandlerKey = "complete_handler";
        $completeHandler = new stdClass;

        $container = new Container();
        $container[$addHandlerKey] = $addHandler;
        $container[$completeHandlerKey] = $completeHandler;

        $pimpleLocator = new PimpleLocator($container, [
            $addCommandName => $addHandlerKey,
            $completeCommandName => $completeHandlerKey,
        ]);

        $this->assertSame(
            $addHandler,
            $pimpleLocator->getHandlerForCommand($addCommandName)
        );

        $this->assertSame(
            $completeHandler,
            $pimpleLocator->getHandlerForCommand($completeCommandName)
        );
    }

    public function testAddMapping()
    {
        $addCommandName = AddTaskCommand::class;
        $addHandlerKey = "add_handler";
        $addHandler = new stdClass;

        $completeCommandName = CompleteTaskCommand::class;
        $completeHandlerKey = "complete_handler";
        $completeHandler = new stdClass;

        $container = new Container();
        $container[$addHandlerKey] = $addHandler;
        $container[$completeHandlerKey] = $completeHandler;

        $pimpleLocator = new PimpleLocator($container);
        $pimpleLocator->addMapping($addCommandName, $addHandlerKey);
        $pimpleLocator->addMapping($completeCommandName, $completeHandlerKey);

        $this->assertSame(
            $addHandler,
            $pimpleLocator->getHandlerForCommand($addCommandName)
        );

        $this->assertSame(
            $completeHandler,
            $pimpleLocator->getHandlerForCommand($completeCommandName)
        );
    }
    /**
     * @expectedException \League\Tactician\Exception\MissingHandlerException
     */
    public function testHandlerMissing()
    {
        $pimpleLocator = new PimpleLocator(new Container());
        $pimpleLocator->getHandlerForCommand(AddTaskCommand::class);
    }
}
