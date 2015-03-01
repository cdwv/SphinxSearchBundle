<?php

namespace Ekiwok\SphinxBundle\Sphinx;

class NullProcessor implements DataProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function processQuery($query, $index, $comment, $success, $time)
    {
        return 0;
    }
    
    /**
     * {@inheritdoc}
     */    
    public function processError($message, $query = null)
    {
    }
}
