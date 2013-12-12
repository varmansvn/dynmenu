<?php

namespace Menu\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Menu\Form\MenuForm;
use Menu\Model\Menu;

class MenuController extends AbstractActionController {

    protected $menuTable = null;

    public function getMenuTable() {
        if (!$this->menuTable) {
            $sm = $this->getServiceLocator();
            $this->menuTable = $sm->get('Menu\Model\MenuTable');
        }

        return $this->menuTable;
    }

    public function indexAction() {
        return new ViewModel(
                array(
            'menus' => $this->getMenuTable()->fetchAll(),
                )
        );
    }

    public function createAction() {
        $form = new MenuForm();
        $form->get('submit')->setValue('Create');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $menu = new Menu();
            $form->setInputFilter($menu->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $menu->exchangeArray($form->getData());
                $this->getMenuTable()->saveMenu($menu);

                // Redirect to list of menus
                return $this->redirect()->toRoute('menu');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        return new ViewModel();
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('menu');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getMenuTable()->deleteMenu($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('menu');
        }

        return array(
            'id' => $id,
            'menu' => $this->getMenuTable()->getMenu($id)
        );
    }

    public function tojsonAction() {
        $menuResultSet = $this->getMenuTable()->fetchAll();
        $menus = array();
        foreach ($menuResultSet as $aMenu) {
            array_push($menus, $aMenu);
        }

        $result = new \Zend\View\Model\JsonModel(array(
            "menus" => $menus
        ));

        return $result;
    }

}
