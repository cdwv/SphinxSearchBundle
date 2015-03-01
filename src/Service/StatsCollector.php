<?php

namespace Ekiwok\SphinxBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Ekiwok\SphinxBundle\Sphinx\DataProcessorInterface;

class StatsCollector extends DataCollector implements DataProcessorInterface
{
    /**
     * Prepars arrays for upcoming data.
     */
    public function __construct()
    {
        $this->data['queries'] = array();
        $this->data['errors'] = array();
        $this->data['warnings'] = array();
        $this->data['time_summary'] = 0; // in milliseconds
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
    }

    /**
     * Returns data processed by collector.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sphinx_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function processQuery($query, $index, $comment, $success, $time)
    {
        $time *=  1000; //to milliseconds
        $toString = sprintf("%s %s", $query, $index);
        $data = compact('toString', 'time', 'success');
        $this->data['queries'][] = $data;
        $this->data['time_summary'] += $time;

        return key(array_slice($this->data['queries'], -1, 1, true));
    }
    
    /**
     * {@inheritdoc}
     */
    public function processError($message, $query = null)
    {
        $this->data['errors'][] = compact('message', 'query');
    }
}
