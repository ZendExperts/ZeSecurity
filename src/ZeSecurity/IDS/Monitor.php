<?php
/**
 * This file is part of ZeSecurity
 *
 * (c) 2012 ZendExperts <team@zendexperts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZeSecurity\IDS;

use Zend\Session\SessionManager,
    IDS_Init,
    IDS_Monitor,
    IDS_Report,
    ZeSecurity\Module;

/**
 * ZeSecurity IDS service monitor
 * @package ZeSecurity
 * @subpackage IDS
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Monitor
{
    protected $config = array();
    protected $ids = null;
    protected $actions = array();
    private $events = null;

    /**
     * Constructor for the monitor. Sets the configuration array for the component and the PHPIDS dependency
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->setConfig($config);
    }

    public function getConfig()
    {
        return $this->config;
    }
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Initialize the PHPIDS monitor
     * @throws \Exception
     */
    public function initMonitor()
    {
        try {
            require_once('IDS/Init.php');
            require_once('IDS/Monitor.php');
            $init = IDS_Init::init();
            $init->setConfig($this->config['options']);
            $request = $this->getRequest();
            $this->ids = new IDS_Monitor($request, $init);
        } catch (\Exception $e) {
            //@todo Handle exception case
            throw $e;
        }
    }

    /**
     * Detect a possible attack in the application from the user
     * @throws \Exception
     */
    public function detect()
    {
        if (!$this->ids){
            $this->initMonitor();
        }

        // run the monitor
        try{
            $report = $this->ids->run();
            // if something found react
            if (!$report->isEmpty()) {
                $this->react($report);
            }
        }catch(\Exception $e){
            //@todo Handle exception case
            throw $e;
        }
    }

    /**
     * React to a potential threat by analyzing the generated report object
     * @param IDS_Report $result
     * @return boolean
     */
    protected function react(IDS_Report $report)
    {
        $impact = $this->aggregateImpactInSession($report);

        $exit = false;
        foreach ($this->config['levels'] as $level=>$options){
            if ($options['max_impact']>=$impact || $options['max_impact']===null){
                if (isset($options['actions'])){
                    foreach ($options['actions'] as $name){
                        if ($action = $this->getAction($name)){
                            $exit = $exit || $action->run($report, $impact, $level, $this);
                        }
                    }
                }
                break;
            }
        }

        //if an action needs to stop execution then return the response and exit
        if ($exit){
            Module::getServiceManager()->get('Application')->getResponse()->send();
            exit();
        }

        return false;
    }

    /**
     * Get an action instance by it's alias
     *
     * @param $name
     * @return Action\ActionInterface | null
     */
    public function getAction($name)
    {
        // return it if it's already created
        if (isset($this->actions[$name])){
            return $this->actions[$name];
        }
        // if not found use the ignore action
        if (!isset($this->config['actions'][$name])){
            return null;
        }else {
            $config = $this->config['actions'][$name];
        }

        // configure the action and return it
        $class = $config['class'];
        $options = isset($config['options']) ? $config['options'] : null;
        $action = new $class();
        if ($options){
            $action->setConfig($options);
        }

        $this->actions[$name] = $action;
        return $action;
    }

    /**
     * If configured aggregate the impact from the report in the session and return the updated value.
     * @param IDS_Report $report
     * @return int
     */
    protected function aggregateImpactInSession(IDS_Report $report)
    {
        if ($this->config['aggregate_in_session']) {
            $sessionManager = new SessionManager();
            $sessionManager->start();
            $session = $sessionManager->getStorage();
            if (!isset($session->ZeSecurityIDS)) {
                $session->ZeSecurityIDS = array('impact' => 0);
            }
            $impact = $session->ZeSecurityIDS['impact'];
            $impact += $report->getImpact();
            $session->ZeSecurityIDS['impact'] = $impact;
        } else {
            $impact = $report->getImpact();
        }
        return $impact;
    }

    /**
     * Returns an array with variables that should be tested for an potential attack
     * @return array
     */
    protected function getRequest()
    {
        $request = array(
            'GET'       => $_GET,
            'POST'      => $_POST,
            'COOKIE'    => $_COOKIE
        );
        return $request;
    }
}