<?php

namespace Ekiwok\SphinxBundle\Sphinx;

class PDOWrapper
{
    /**
     * @var \PDO
     */
    protected $pdo = null;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var DataProcessorInterface
     */
    protected $collector;

    /**
     * @param string                 $host
     * @param integer                $port
     * @param DataProcessorInterface $collector
     */
    public function __construct($host = '127.0.0.1', $port = 9306, DataProcessorInterface $collector = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->collector = is_null($collector)
                         ? new NullProcessor()
                         : $collector;
    }

    /**
     * @throws PDOException
     * @param string $query
     * @return false|array
     */
    public function query($query)
    {
        $time = microtime(true);
        $result = $this->concreteQuery($query);
        $elapsed = (microtime(true) - $time);
        $query = $this->collector->processQuery($query, $index = '', $comment = '', $result !== false, $elapsed);
        if ($result === false) {
            $errorInfo = $this->pdo()->errorInfo();
            $lastError = implode(';', $errorInfo);
            $this->collector->processError($lastError, $query);
        }

        return $result;
    }

    /**
     * @throws PDOException
     * @param string $query
     * @return false|array
     */
    protected function concreteQuery($query)
    {
        $statement = $this->pdo()->query($query);
        if ($statement === false) {
            return false;
        }
        $success = $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Lazy instantiates PDO object.
     *
     * @throws PDOException
     * @return PDO
     */
    protected function pdo()
    {
        if (!is_null($this->pdo)) {
            return $this->pdo;
        }
        $dsn = sprintf("mysql:host=%s;port=%d", $this->host, $this->port);
        try {
            $this->pdo = new \PDO($dsn, "", "");
        } catch (\PDOException $e) {
            $this->collector->processError($e->getMessage());
            throw $e;
        }

        return $this->pdo;
    }
}
