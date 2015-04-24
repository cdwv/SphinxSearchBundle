<?php

namespace Ekiwok\SphinxBundle\Sphinx\QL;

use Foolz\SphinxQL\Drivers\ConnectionInterface;
use Foolz\SphinxQL\Drivers\PdoConnection;
use Foolz\SphinxQL\Drivers\SimpleConnection;
use Foolz\SphinxQL\SphinxQL;
use Ekiwok\SphinxBundle\Exception\ConnectionException;

class Connection implements ConnectionInterface
{
    const DRIVER_PDO = 'pdo';
    const DRIVER_MYSQLI = 'mysqli';

    /**
     * @var \ConnectionInterface
     */
    protected $connection;

    /**
     * @var array
     */
    protected $config;

    public static function getSupportedDrivers()
    {
        return array(self::DRIVER_PDO, self::DRIVER_MYSQLI);
    }

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        switch ($config['driver'])
        {
            case self::DRIVER_PDO:
                $this->connection = new PdoConnection(array('host' => $this->config['host'], 'port' => $this->config['port']));
            return;

            case self::DRIVER_MYSQLI:
                $this->connection = new PdoConnection(array('host' => $this->config['host'], 'port' => $this->config['port']));
            return;
        }

        throw ConnectionException::unsupportedDriver($config['driver'], self::getSupportedDrivers());
    }

    /**
     * @return \SphinxQL
     */
    public function createQueryBuilder()
    {
        return SphinxQL::create($this);
    }

    /**
     * {@inheritdoc }
     */
    public function query($query)
    {
        return $this->connection->query($query);
    }

    /**
     * {@inheritdoc }
     */
    public function multiQuery(Array $queue)
    {
        return $this->connection->multiQuery($queue);
    }

    /**
     * {@inheritdoc }
     */
    public function escape($value)
    {
        return $this->connection->escape($value);
    }

    /**
     * {@inheritdoc }
     */
    public function quoteIdentifier($value)
    {
        return $this->connection->quoteIdentifier($value);
    }

    /**
     * {@inheritdoc }
     */
    public function quoteIdentifierArr(Array $array = array())
    {
        return $this->connection->quoteIdentifierArr($array);
    }

    /**
     * {@inheritdoc }
     */
    public function quote($value)
    {
        return $this->connection->quote($value);
    }

    /**
     * {@inheritdoc }
     */
    public function quoteArr(Array $array = array())
    {
        return $this->connection->quoteAttr($array);
    }
}
