<?php

namespace Ekiwok\SphinxBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Ekiwok\SphinxBundle\Sphinx\SphinxDataProcessorInterface;

class SphinxStatsCollector extends DataCollector implements SphinxDataProcessorInterface
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

        $this->data = array(
            'queries' => array(),
            'errors'  => array(),
            'warnings' => array(),
            'time_summary' => 0,
            'sql' => array(
                    'queries' => array(),
                    'errors' => array(),
                    'time_summary' => 0
                )
        );
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
    public function processAPIQuery($query, $index, $comment, $success, $time)
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
    public function processSQLQuery($query, array $info)
    {
        $tmp =& $this->data['sql'];
        foreach ($info as $piece) {
            switch ($piece['Variable_name'])
            {
                case 'time':
                    $time = (float) $piece['Value'];
                    $tmp['time_summary'] += $time;
                continue;
            }
        }
        $tmp['queries'][] = compact('time', 'query');

    }
    
    /**
     * {@inheritdoc}
     */
    public function processError($message, $query = null)
    {
        $this->data['errors'][] = compact('message', 'query');
    }

    /**
     * Total number of called queries.
     * 
     * @return integer
     */
    public function getQueriesCount()
    {
        $api = count($this->data['queries']);
        $sql = count($this->data['sql']['queries']);

        return $api + $sql;
    }
}
