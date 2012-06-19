<?php
namespace ZeSecurity\IDS\Action;
use IDS_Report,
    ZeSecurity\IDS\Monitor;

interface ActionInterface
{
    /**
     * Set the configuration array for the action object
     * @abstract
     * @param array|null $config
     */
    public function setConfig($config);

    /**
     * @abstract
     * @param IDS_Report $report
     * @param int $impact
     * @param string $level
     * @return bool
     */
    public function run(IDS_Report $report, $impact, $level, Monitor $monitor = null);
}