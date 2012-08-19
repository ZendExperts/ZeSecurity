<?php
/**
 * This file is part of ZeSecurity
 *
 * (c) 2012 ZendExperts <team@zendexperts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZeSecurity;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\Mvc\MvcEvent,
    IDS\MonitorFactory;

/**
 * ZeSecurity Module class
 * @package ZeSecurity
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Module implements AutoloaderProviderInterface
{
    protected static $serviceManager = null;

    public function onBootstrap(MvcEvent $event)
    {
        // Set the static service manager instance so we can use it everywhere in the module
        $app = $event->getApplication();
        self::$serviceManager = $app->getServiceManager();
        $idsMonitor = self::$serviceManager->get('ZeSecurityIDS');

        $idsMonitor->detect();
        unset($idsMonitor);
    }

    /**
     * Get Autoloader Config
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload/classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Get Service Configuration
     * @return array
     */
    public function getServiceConfig(){
        return include __DIR__ . '/config/service.config.php';
    }

    /**
     * Get Module Configuration
     * @return mixed
     */
    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';
        return $config;
    }

    /**
     * Return the ServiceManager instance
     * @static
     * @return \Zend\ServiceManager\ServiceManager
     */
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

}