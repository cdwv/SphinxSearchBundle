<?php

namespace Ekiwok\SphinxBundle\Sphinx;

interface ConnectionInterface
{
    /**
     * Returns connection instance which may vary.
     *
     * @return mixed
     */
    public function get();

    /**
     * Connection name.
     *
     * @return string
     */
    public function getName();
}
