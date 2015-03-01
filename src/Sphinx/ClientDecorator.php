<?php

namespace Ekiwok\SphinxBundle\Sphinx;

use Sphinx\SphinxClient;

class ClientDecorator extends SphinxClient
{
    /**
     * @var SphinxClient
     */
    protected $proxy;

    /**
     * @param SphinxClient $client
     */    
    public function __construct(SphinxClient $client)
    {
        $this->proxy = $client;
    }

    /**
     * {@inheritdoc}
     */
    public static function create()
    {
        return $this->proxy->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastError()
    {
        return $this->proxy->getLastError();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastWarning()
    {
        return $this->proxy->getLastWarning();
    }

    /**
     * {@inheritdoc}
     */
    public function isConnectError()
    {
        return $this->proxy->isConnectError();
    }

    /**
     * {@inheritdoc}
     */
    public function setServer($host, $port = 0)
    {
        return $this->proxy->setServer($host, $port);
    }

    /**
     * {@inheritdoc}
     */
    public function setConnectTimeout($timeout)
    {
        return $this->proxy->setConnectTimeout($timeout);
    }

    /**
     * {@inheritdoc}
     */
    public function setLimits($offset, $limit, $max = 0, $cutoff = 0)
    {
        return $this->proxy->setLimits($offset, $limit, $max, $cutoff);
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxQueryTime($max)
    {
        return $this->proxy->setMaxQueryTime($max);
    }

    /**
     * {@inheritdoc}
     */
    public function setMatchMode($mode)
    {
        return $this->proxy->setMatchMode($mode);
    }

    /**
     * {@inheritdoc}
     */
    public function setRankingMode($ranker, $rankexpr = '')
    {
        return $this->proxy->setRankingMode($ranker, $rankexpr);
    }

    /**
     * {@inheritdoc}
     */
    public function setSortMode($mode, $sortby = '')
    {
        return $this->proxy->setSortMode($mode, $sortby);
    }

    /**
     * {@inheritdoc}
     */
    public function setWeights(array $weights)
    {
        return $this->proxy->setWeights($weights);
    }

    /**
     * {@inheritdoc}
     */
    public function setFieldWeights(array $weights)
    {
        return $this->proxy->setFieldWeights($weights);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndexWeights(array $weights)
    {
        return $this->proxy->setIndexWeights($weights);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdRange($min, $max)
    {
        return $this->proxy->setIdRange($min, $max);
    }

    /**
     * {@inheritdoc}
     */
    public function setFilter($attribute, array $values, $exclude = false)
    {
        return $this->proxy->setFilter($attribute, $values, $exclude);
    }

    /**
     * {@inheritdoc}
     */
    public function setFilterRange($attribute, $min, $max, $exclude = false)
    {
        return $this->proxy->setFilterRange($attribute, $min, $max, $exclude);
    }

    /**
     * {@inheritdoc}
     */
    public function setFilterFloatRange($attribute, $min, $max, $exclude = false)
    {
        return $this->proxy->setFilterFloatRange($attribute, $min, $max, $exclude);
    }

    /**
     * {@inheritdoc}
     */
    public function setGeoAnchor($attrlat, $attrlong, $lat, $long)
    {
        return $this->proxy->setGeoAnchor($attrlat, $attrlong, $lat, $long);
    }

    /**
     * {@inheritdoc}
     */
    public function setGroupBy($attribute, $func, $groupsort = '@group desc')
    {
        return $this->proxy->setGroupBy($attribute, $func, $groupsort);
    }

    /**
     * {@inheritdoc}
     */
    public function setGroupDistinct($attribute)
    {
        return $this->proxy->setGroupDistinct($attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function setRetries($count, $delay = 0)
    {
        return $this->proxy->setRetries($count, $delay);
    }

    /**
     * {@inheritdoc}
     */
    public function setArrayResult($arrayresult)
    {
        return $this->proxy->setArrayResult($arrayresult);
    }

    /**
     * {@inheritdoc}
     */
    public function setOverride($attrname, $attrtype, array $values)
    {
        return $this->proxy->setOverride($attrname, $attrtype, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function setSelect($select)
    {
        return $this->proxy->setSelect($select);
    }

    /**
     * {@inheritdoc}
     */
    public function resetFilters()
    {
        return $this->proxy->resetFilters();
    }

    /**
     * {@inheritdoc}
     */
    public function resetGroupBy()
    {
        return $this->proxy->resetGroupBy();
    }

    /**
     * {@inheritdoc}
     */
    public function resetOverrides()
    {
        return $this->proxy->resetOverrides();
    }

    /**
     * {@inheritdoc}
     */
    public function query($query, $index = '*', $comment = '')
    {
        return $this->proxy->query($query, $index, $comment);
    }

    /**
     * {@inheritdoc}
     */
    public function addQuery($query, $index = '*', $comment = '')
    {
        return $this->proxy->addQuery($query, $index, $comment);
    }

    /**
     * {@inheritdoc}
     */
    public function runQueries()
    {
        return $this->proxy->runQueries();
    }

    /**
     * {@inheritdoc}
     */
    public function buildExcerpts(array $docs, $index, $words, array $opts = array())
    {
        return $this->proxy->buildExcerpts($docs, $index, $words, $opts);
    }

    /**
     * {@inheritdoc}
     */
    public function buildKeywords($query, $index, $hits)
    {
        return $this->proxy->buildKeywords($query, $index, $hits);
    }

    /**
     * {@inheritdoc}
     */
    public function escapeString($string)
    {
        return $this->proxy->escapeString($string);
    }

    /**
     * {@inheritdoc}
     */
    public function updateAttributes($index, array $attrs, array $values, $mva = false)
    {
        return $this->proxy->updateAttributes($index, $attrs, $values, $mva);
    }

    /**
     * {@inheritdoc}
     */
    public function open()
    {
        return $this->proxy->open();
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return $this->proxy->close();
    }

    /**
     * {@inheritdoc}
     */
    public function status()
    {
        return $this->proxy->status();
    }

    /**
     * {@inheritdoc}
     */
    public function flushAttributes()
    {
        return $this->proxy->flushAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function packI64($v)
    {
        return $this->proxy->packI64($v);
    }

    /**
     * {@inheritdoc}
     */
    public function packU64($v)
    {
       return $this->proxy->packU64($v);
    }

    /**
     * {@inheritdoc}
     */
    public function unpackU64($v)
    {
        return $this->proxy->unpackU64($v);
    }

    /**
     * {@inheritdoc}
     */
    public function unpackI64($v)
    {
        return $this->proxy->unpackI64($v);
    }

    /**
     * {@inheritdoc}
     */
    public function fixUint($value)
    {
        return $this->proxy->fixUint($value);
    }
}
