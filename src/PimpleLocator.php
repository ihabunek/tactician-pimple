<?php

namespace League\Tactician\Pimple;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

use Pimple\Container;

/**
 * Fetches handler instances from a Pimple container.
 */
class PimpleLocator implements HandlerLocator
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Maps command names to keys in the Pimple container which contain a
     * command handler.
     *
     * @var array
     */
    protected $commandToKeyMap;

    /**
     * @param Container $container
     * @param array     $commandToKeyMap
     */
    public function __construct(
        Container $container,
        array $commandToKeyMap = []
    ) {
        $this->container = $container;
        $this->commandToKeyMap = $commandToKeyMap;
    }

    /**
     * Adds a new mapping.
     *
     * @param string $commandName
     * @param string $key
     */
    public function addMapping($commandName, $key)
    {
        $this->commandToKeyMap[$commandName] = $key;
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        if (!isset($this->commandToKeyMap[$commandName])) {
            throw MissingHandlerException::forCommand($commandName);
        }

        $key = $this->commandToKeyMap[$commandName];

        return $this->container[$key];
    }
}
