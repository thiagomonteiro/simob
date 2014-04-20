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
namespace Application\Form;
use Zend\Form\Form;

class criarBairro extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel('Nome');
        $uf = new \Zend\Form\Element\Select('uf');
        $uf->setLabel('uf');
        $uf->setAttribute('id', 'uf-select');
        $uf->setDisableInArrayValidator(true);
        $cidade = new \Zend\Form\Element\Select('cidade');
        $cidade->setAttribute('id', 'cidade-select');
        $cidade->setEmptyOption('selecione estado');
        $cidade->setLabel('Cidade');
        $cidade->setDisableInArrayValidator(true);
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'salvar','id'=>'bairro-submit'));
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-criar-bairro'));
        $this->add($nome);
        $this->add($uf);
        $this->add($cidade);
        $this->add($submit);
    }
}