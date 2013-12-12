<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuForm
 *
 * @author varmansvn
 */

namespace Menu\Form;

use Zend\Form\Form;

class MenuForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('menu');

        $this->add(array(
            'name' => 'menu_id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'menu_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'url',
            'type' => 'Text',
            'options' => array(
                'label' => 'Url',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

}
