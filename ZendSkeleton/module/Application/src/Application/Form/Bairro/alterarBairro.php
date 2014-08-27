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
namespace Application\Form\Bairro;
use Zend\Form\Form;

class alterarBairro extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $id =  new \Zend\Form\Element\Hidden('id');
        $id->setAttribute('class', 'upd-id');
        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel('Nome');
        $uf = new \Zend\Form\Element\Select('uf');
        $uf->setAttribute('class', 'uf-upd-select');
        $uf->setLabel('Uf');
        $uf->setDisableInArrayValidator(true);
        $cidade = new \Zend\Form\Element\Select('cidade');
        $cidade->setAttribute('class', 'cidade-select');
        $cidade->setLabel('Cidade');
        $cidade->setDisableInArrayValidator(true);
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-alterar-bairro'));
        $this->add($id);
        $this->add($nome);
        $this->add($uf);
        $this->add($cidade);
    }
}