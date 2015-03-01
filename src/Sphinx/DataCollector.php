<?php

namespace Ekiwok\SphinxBundle\Sphinx;

use Sphinx\SphinxClient;

class SphinxDataCollector extends SphinxClientDecorator
{
    /**
     * @var SphinxDataProcessorInterface
     */
    protected $collector;

    /**
     * @param SphinxClient $client
     * @param SphinxDataProcessorInterface $collector
     */
    public function __construct(SphinxClient $client, DataProcessorInterface $collector = null)
    {
        parent::__construct($client);
        $this->collector = $collector;
    }


    public function query($query, $index = '*', $comment = '')
    {
        $time = microtime(true);
        $result = $this->proxy->query($query, $index, $comment);
        $elapsed = (microtime(true) - $time);
        $query = $this->collector->processQuery($query, $index, $comment, $result !== false, $elapsed);
        if ($result === false) {
            $lastError = $this->proxy->getLastError();
            $this->collector->processError($lastError, $query);
        }

        return $result;
    }
}
