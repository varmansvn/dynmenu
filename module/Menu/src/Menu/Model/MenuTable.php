<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuTable
 *
 * @author varmansvn
 */
namespace Menu\Model;
  
use Zend\Db\TableGateway\TableGateway;
 
class MenuTable {
    
    //put your code here

    protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
        $resultSet = $this->tableGateway->select();
      
        return $resultSet;
     }

     public function getMenu($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('menu_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveMenu(Menu $menu)
     {
         $data = array(
             'menu_name' => $menu->menu_name,             
             'url' => $menu->url
         );

         $id = (int) $menu->menu_id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getMenu($id)) {
                 $this->tableGateway->update($data, array(
                     'menu_id' => $id));
             } else {
                 throw new \Exception('Menu id does not exist');
             }
         }
     }

     public function deleteMenu($id)
     {
         $this->tableGateway->delete(array('menu_id' => (int) $id));
     }
}
