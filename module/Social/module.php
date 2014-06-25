<?php
namespace Social;

// Add these import statements:
use Social\Model\Member;
use Social\Model\MemberTable;
use Social\Model\Group;
use Social\Model\GroupTable;
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
                'Social\Model\GroupTable' =>  function($sm) {
                    $tableGateway = $sm->get('GroupTableGateway');
                    $table = new GroupTable($tableGateway);
                    return $table;
                },
                'Social\Model\MemberTable' =>  function($sm) {
                    $tableGateway = $sm->get('MemberTableGateway');
                    $table = new MemberTable($tableGateway);
                    return $table;
                },
                'MemberTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Member());
                    return new TableGateway('member', $dbAdapter, null, $resultSetPrototype);
                },
                'GroupTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Group());
                    return new TableGateway('group', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}

