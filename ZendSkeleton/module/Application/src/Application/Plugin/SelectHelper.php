<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SelectHelper extends AbstractPlugin{
    
    public function getArrayData($default,$dados){
        $select = array();
        $select[] =  array('value' => "",'label' => $default,'disabled' => 'disabled','selected' => 'selected');
        foreach($dados as $row){
            $select[$row->getId()] = array('value' => $row->getId(), 'label' => $row->getDescricao());
        }
        return $select;
    }
    
}