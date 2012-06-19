<?php
namespace ZeSecurity\IDS\Action;
use IDS_Report,
    ZeSecurity\IDS\Monitor;

class Log extends AbstractAction
{
    /**
     * @todo Based on the configuration add a log entry in the registry
     *
     * @param IDS_Report $report
     * @param int $impact
     * @param string $level
     * @return bool
     */
    public function run(IDS_Report $report, $impact, $level, Monitor $monitor = null)
    {
        if (isset($this->config['log_factory'])){
            $factoryClass = $this->config['log_factory'];
        }else{
            $factoryClass = 'ZeSecurity\IDS\Action\Log\LogFactory';
        }

        $factory = new $factoryClass();
        $log = $factory->create($this->config);

        $origin = $_SERVER['SERVER_ADDR'];
        $ip = $_SERVER['REMOTE_ADDR'] .
            (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
                ' (' . $_SERVER['HTTP_X_FORWARDED_FOR'] . ')' : '');
        $date = date('c');
        $params = array();
        foreach($report->getIterator() as $event){
            $params[] = $event->getName() . '=' . $event->getValue();
        }
        $params = implode(', ', $params);
        $requestURI = htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
        $tags = implode(' ', $report->getTags());
        $actions = "log";
        if ($monitor){
            $conf = $monitor->getConfig();
            $actions = implode(', ', $conf['levels'][$level]['actions']);
        }
        $log->alert(<<<END
A possible attack has been detected by ZeSecurity IDS:
IP: $ip
Date: $date
URI: $requestURI
Tags: $tags
Actions taken: $actions
Origin: $origin
Raised By:
$params

END
);
        return false;
    }

}