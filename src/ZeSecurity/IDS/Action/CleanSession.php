<?php
namespace ZeSecurity\IDS\Action;
use IDS_Report,
    ZeSecurity\Module,
    ZeSecurity\IDS\Monitor;

class CleanSession extends AbstractAction
{
    /**
     * @param IDS_Report $report
     * @param int $impact
     * @param string $level
     * @return bool
     */
    public function run(IDS_Report $report, $impact, $level, Monitor $monitor = null)
    {
        $session = new \Zend\Session\SessionManager();
        $session->destroy($this->config);
        return false;
    }

}