<?php

namespace Ekiwok\SphinxBundle\Sphinx;

interface SphinxDataProcessorInterface
{
    /**
     * @param string $query
     * @param string $index
     * @param string $comment
     * @param boolean $success
     * @param float $time       in seconds
     * @return integer          query identifier
     */
    public function processAPIQuery($query, $index, $comment, $success, $time);

    /**
     * @param  string  $query
     * @param  string  $success
     * @param  integer $time
     * @return integer          query identifier
     */
    public function processSQLQuery($query, array $info);
    
    /**
     * @param string $message
     * @param integer $query   identyfikator zapytania
     * @return void
     */
    public function processError($message, $query = null);
}
