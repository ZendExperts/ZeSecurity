<?php
namespace ZeSecurity\IDS\Action\Log;

interface FactoryInterface
{
    /**
     * Factory method for creating a log object
     * @abstract
     * @param array $config
     */
    public function create($config);
}