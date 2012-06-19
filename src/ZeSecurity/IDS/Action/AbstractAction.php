<?php
namespace ZeSecurity\IDS\Action;
use IDS_Report;

abstract class AbstractAction implements ActionInterface
{
    protected $config = null;

    /**
     * Set the configuration array for the action object
     * @param array|null $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}