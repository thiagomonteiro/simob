<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Proprietario;
use Zend\Form\Form;

class busca extends Form{
    public function __construct($name = null, $options = array(),$filtro=null,$param=null) {
        parent::__construct($name, $options);
        $hiddenParam = new \Zend\Form\Element\Hidden('hidden-param');
        $hiddenParam->setAttribute('id', 'hidden-param'); 
        $hiddenParam->setValue($param);
        $hiddenFiltro = new \Zend\Form\Element\Hidden('hidden-filtro');
        $hiddenFiltro->setAttribute('id', 'hidden-filtro'); 
        $hiddenFiltro->setValue($filtro);
        $param = new \Zend\Form\Element\Text('param');
        $param->setAttribute('id', 'param');  
        $param->setLabel('busca');
        $filtro = new \Zend\Form\Element\Select('filtro');
        $filtro->setAttribute('id', 'filtro');
        $filtro->setLabel('filtro');
        $filtro->setDisableInArrayValidator(true);
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'buscar','id'=>'busca-submit'));
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-busca'));
        $this->add($hiddenParam);
        $this->add($hiddenFiltro);
        $this->add($param);
        $this->add($filtro);
        $this->add($submit);
    }
}