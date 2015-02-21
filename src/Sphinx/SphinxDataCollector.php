<?php
/**
 * @Author: ekiwok
 * @Date:   2015-02-19 14:28:43
 * @Last Modified by:   ekiwok
 * @Last Modified time: 2015-02-19 20:22:45
 */

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
    public function __construct(SphinxClient $client, SphinxDataProcessorInterface $collector = null)
    {
        parent::__construct($client);
        $this->collector = $collector;
    }

    /**
     * {@inheritdoc }
     */
    public function query($query, $index = '*', $comment = '')
    {
        $time = microtime(true);
        $result = $this->proxy->query($query, $index, $comment);
        $elapsed = (microtime(true) - $time);
        $query = $this->collector->processAPIQuery($query, $index, $comment, $result !== false, $elapsed);
        if ($result === false) {
            $lastError = $this->proxy->getLastError();
            $this->collector->processError($lastError, $query);
        }

        return $result;
    }
}
