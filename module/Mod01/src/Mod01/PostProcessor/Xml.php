<?php

namespace Mo01\PostProcessor;

/**
 *
 */
class Xml extends AbstractPostProcessor
{
    public function process()
    {
        $result = $this->serializer->serialize($this->_vars,'xml');

        $this->_response->setContent($result);

        $headers = $this->_response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/xml');
        $this->_response->setHeaders($headers);

    }

}
