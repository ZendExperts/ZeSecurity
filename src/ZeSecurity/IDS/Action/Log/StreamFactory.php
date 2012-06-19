<?php
namespace ZeSecurity\IDS\Action\Log;

use Zend\Log\Writer\Stream;

class StreamFactory implements FactoryInterface
{
    /**
     * Factory method for creating a log object
     * @param array $config
     * @return \Zend\Log\Writer\Stream
     */
    public function create($config)
    {
        $stream = $config['stream'];
        $mode = null;
        if (isset($config['mode'])){
            $mode = $config['mode'];
        }
        $writer = new Stream($stream, $mode);
        if (isset($config['formatter'])) {
            $formatter = new $config['formatter']();
            $writer->setFormatter($formatter);
        }
        return $writer;
    }

}