<?php
namespace ZeSecurity\IDS\Action\Log;

use Zend\Log\Logger;

class LogFactory implements FactoryInterface
{
    /**
     * Factory method for creating a log object
     * @param array $config
     * @return Zend\Log\Logger
     */
    public function create($config)
    {
        $factoryClass = $config['writer_factory'];
        $factory = new $factoryClass();
        $writer = $factory->create($config);
        $logger = new Logger();
        $logger->addWriter($writer);
        return $logger;
    }

}