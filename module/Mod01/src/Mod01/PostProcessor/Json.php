<?php

namespace Mod01\PostProcessor;

/**
 *
 */
class Json extends AbstractPostProcessor
{
    public function process()
    {
        $result = $this->serializer->serialize($this->_vars,'json');

        $this->_response->setContent($result);

        $headers = $this->_response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
        $this->_response->setHeaders($headers);
    }
}
