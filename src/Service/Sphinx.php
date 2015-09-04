<?php

namespace Ekiwok\SphinxBundle\Service;

use Ekiwok\SphinxBundle\Exception\ConnectionException;
use Ekiwok\SphinxBundle\Sphinx\QL\Connection;
use Ekiwok\SphinxBundle\Sphinx\SphinxDataProcessorInterface;

class Sphinx
{

    const DEFAULT_HOST = 'localhost';
    const DEFAULT_PORT = 9306;
    const DEFAULT_DRIVER = 'pdo';

    /**
     * @var array
     */
    protected $config;

    /**
     * @var SphinxDataProcessorInterface
     */
    protected $processor;

    /**
     * @var array
     */
    protected $connections = array();

    /**
     * @param array $config configuration
     * @param SphinxDataProcessorInterface $processor
     */
    public function __construct(array $config, SphinxDataProcessorInterface $processor)
    {
        $this->processor = $processor;
        $this->config = $config['connections'];

        if (!isset($config['connections']['default'])) {
            $config['connections']['default'] = array(
                'host' => self::DEFAULT_HOST,
                'port' => self::DEFAULT_PORT,
                'driver' => self::DEFAULT_DRIVER
            );
        }
    }

    /**
     * @param  string $name
     * @return Connection
     */
    public function getConnection($name = 'default')
    {
        if (!isset($this->config[$name])) {
            throw ConnectionException::missingConnection($name, array_keys($this->config));
        }

        if (!isset($this->connections[$name])) {
            $this->connections[$name] = new Connection($this->config[$name], $this->processor);
        }

        return $this->connections[$name];
    }

}
