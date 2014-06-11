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

class criar extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $descricao = new \Zend\Form\Element\Text('descricao');
        $descricao->setLabel('descricao');
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-comodo-criar'));
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'salvar','id'=>'comodo-submit'));
        $this->add($descricao);
        $this->add($submit);
    }
}