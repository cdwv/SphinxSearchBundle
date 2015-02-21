<?php

namespace Ekiwok\SphinxBundle\Sphinx\QL;

use Foolz\SphinxQL\Drivers\ConnectionInterface as FoolzConnectionInterface;

interface ConnectionInterface extends FoolzConnectionInterface
{
    /**
     * @return \Foolz\SphinxQL\SphinxQL
     */
    public function createQueryBuilder();
}
