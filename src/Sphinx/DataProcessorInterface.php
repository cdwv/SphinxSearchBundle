<?php

namespace Ekiwok\SphinxBundle\Sphinx;

interface DataProcessorInterface
{
    /**
     * @param string $query
     * @param string $index
     * @param string $comment
     * @param boolean $success
     * @param float $time       in seconds
     * @return integer          query identifier
     */
    public function processQuery($query, $index, $comment, $success, $time);
    
    /**
     * @param string $message
     * @param integer $query   identyfikator zapytania
     * @return void
     */
    public function processError($message, $query = null);
}