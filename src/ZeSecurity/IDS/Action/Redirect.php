<?php
namespace ZeSecurity\IDS\Action;
use IDS_Report,
    ZeSecurity\Module,
    ZeSecurity\IDS\Monitor;

class Redirect extends AbstractAction
{
    /**
     * @param IDS_Report $report
     * @param int $impact
     * @param string $level
     * @return bool
     */
    public function run(IDS_Report $report, $impact, $level, Monitor $monitor = null)
    {
        $service = Module::getServiceManager();
        $application = $service->get('Application');
        $response = $application->getResponse();
        $response->headers()->addHeaderLine('Location', $this->config['url']);
        $response->setStatusCode(302);
        return true;
    }

}