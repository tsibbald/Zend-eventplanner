<?php
namespace Calender;

// Add these import statements:
use Calender\Model\Events;
use Calender\Model\EventsTable;
use Calender\Model\Guest;
use Calender\Model\GuestTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Calender\Model\EventsTable' =>  function($sm) {
                    $tableGateway = $sm->get('EventsTableGateway');
                    $table = new EventsTable($tableGateway);
                    return $table;
                },
                 'Calender\Model\GuestTable' =>  function($sm) {
                    $tableGateway = $sm->get('GuestTableGateway');
                    $table = new GuestTable($tableGateway);
                    return $table;
                },
                'EventsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Events());
                    return new TableGateway('events', $dbAdapter, null, $resultSetPrototype);
                },
                 'GuestTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Events());
                    return new TableGateway('guest', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}

