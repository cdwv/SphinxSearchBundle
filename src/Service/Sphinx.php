<?php

namespace Ekiwok\SphinxBundle\Service;

class Sphinx
{

    const DEFAULT_HOST = 'localhost';
    const DEFAULT_PORT = 9306;
    const DEFAULT_DRIVER = 'pdo';

    /**
     * @param array $config configuration
     */
    public function __construct(array $config)
    {
        if (!isset($config['connections']['default'])) {
            $config['connections']['default'] = array(
                    'host' => self::DEFAULT_HOST,
                    'port' => self::DEFAULT_PORT,
                    'driver' => self::DEFAULT_DRIVER
                );
            $this->connections = $config['connections'];
        }
    }

}
