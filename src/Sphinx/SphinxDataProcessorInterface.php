<?php
/**
 * @Author: ekiwok
 * @Date:   2015-02-19 16:04:21
 * @Last Modified by:   ekiwok
 * @Last Modified time: 2015-02-19 20:24:41
 */

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
    public function processQuery($query, $index, $comment, $success, $time);
    
    /**
     * @param string $message
     * @param integer $query   identyfikator zapytania
     * @return void
     */
    public function processError($message, $query = null);
}