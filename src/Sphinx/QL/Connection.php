<?php

namespace Ekiwok\SphinxBundle\Sphinx\QL;

use Foolz\SphinxQL\Drivers\PdoConnection;
use Foolz\SphinxQL\Drivers\SimpleConnection;
use Foolz\SphinxQL\SphinxQL;
use Ekiwok\SphinxBundle\Sphinx\SphinxDataProcessorInterface;
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

    /**
     * @var SphinxDataProcessorInterface
     */
    protected $processor;

    /**
     * @return array
     */
    public static function getSupportedDrivers()
    {
        return array(self::DRIVER_PDO, self::DRIVER_MYSQLI);
    }

    /**
     * @param array $config
     */
    public function __construct(array $config, SphinxDataProcessorInterface $processor)
    {
        $this->config = $config;
        $this->processor = $processor;
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
     * {@inheritdoc }
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
        try {
            $result = $this->connection->query($query);
        } catch (\Exception $e) {
            $this->processor->processError($e->getMessage());
            throw $e;
        } finally {
            $meta = $this->connection->query('SHOW META');
            $this->processor->processSQLQuery($query, $meta);
        }

        return $result;
    }

    /**
     * {@inheritdoc }
     */
    public function multiQuery(Array $queue)
    {
        try {
            $result = $this->connection->multiQuery($queue);
        } catch (\Exception $e) {
            $this->processor->processError($e->getMessage());
            throw $e;
        } finally {
            $meta = $this->connection->query('SHOW META');
            $this->processor->processSQLQuery(implode(';', $queue), $meta);
        }

        return $result;
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
        return $this->connection->quoteArr($array);
    }
}
