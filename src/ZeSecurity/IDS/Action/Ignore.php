<?php
namespace ZeSecurity\IDS\Action;
use IDS_Report,
    ZeSecurity\IDS\Monitor;

class Ignore extends AbstractAction
{
    /**
     * @param IDS_Report $report
     * @param int $impact
     * @param string $level
     * @return bool
     */
    public function run(IDS_Report $report, $impact, $level, Monitor $monitor = null)
    {
        //do nothing
    }

}