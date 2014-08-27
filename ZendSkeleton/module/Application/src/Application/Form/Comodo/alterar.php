<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of criarBairro
 *
 * @author thiago
 */
namespace Application\Form\Comodo;
use Zend\Form\Form;

class alterar extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $id =  new \Zend\Form\Element\Hidden('id');
        $id->setAttribute('class', 'upd-id');
        $descricao = new \Zend\Form\Element\Text('descricao');
        $descricao->setLabel('descricao');
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-alterar'));
        $this->add($id);
        $this->add($descricao);
    }
}