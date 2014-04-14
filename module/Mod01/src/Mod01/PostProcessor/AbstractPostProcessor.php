<?php

namespace Mod01\PostProcessor;

use JMS\Serializer\Serializer;

abstract class AbstractPostProcessor
{

    /**
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     * @var array|null
     */
    protected $_vars = null;

    /**
     * @var null|\Zend\Http\Response
     */
    protected $_response = null;

    /**
     * @param $vars
     * @param \Zend\Http\Response $response
     */
    public function __construct(\Zend\Http\Response $response, $vars = null, Serializer $serializer)
    {
        $this->_vars = $vars;
        $this->_response = $response;
        $this->serializer = $serializer;
    }

    /**
     * @return null|\Zend\Http\Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @abstract
     */
    abstract public function process();
}
