<?php
namespace Menu;

use Menu\Model\Menu;
use Menu\Model\MenuTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig() {
         return array(
             'factories' => array(
                 'Menu\Model\MenuTable' =>  function($sm) {
                     $tableGateway = $sm->get('MenuTableGateway');
                     $table = new MenuTable($tableGateway);
                     return $table;
                 },
                 'MenuTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Menu());
                     return new TableGateway('tbl_menu', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
}
