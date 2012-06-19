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

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * ZeSecurity service monitor factory
 * @package ZeSecurity
 * @component IDS
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class MonitorFactory implements FactoryInterface
{
    /**
     * Factory method for ZeSecurity IDS Monitor service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Monitor
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $monitor = new Monitor($config['zendexperts_security']['IDS']);
        return $monitor;
    }
}