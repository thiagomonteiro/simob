<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Site\Form\Index;
use Zend\Form\Form;

class busca extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $cidade = new \Zend\Form\Element\Select('cidade');
        $cidade->setAttribute('class', 'cidade-select');
        $cidade->setLabel('Cidade');
        $cidade->setDisableInArrayValidator(true);
        $bairro = new \Zend\Form\Element\Select('bairro');
        $bairro->setAttribute('class', 'bairro-select');
        $bairro->setLabel('Bairro');
        $bairro->setDisableInArrayValidator(true);
        $bairro->setDisableInArrayValidator(true);
        $tipo = new \Zend\Form\Element\Select('tipo');
        $tipo->setAttribute('class', 'filtro-tipo');
        $tipo->setLabel('Tipo');
        $tipo->setDisableInArrayValidator(true);
        $finalidade = new \Zend\Form\Element\Select('transacao');
        $finalidade->setAttribute('class', 'filtro-transacao');
        $finalidade->setLabel('Uso');
        $finalidade->setDisableInArrayValidator(true);
        $valor = new \Zend\Form\Element\Select('valor');
        $valor->setAttribute('class','filtro-valor');
        $valor->setLabel('Preço');
        $valor->setDisableInArrayValidator(true);
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'buscar','id'=>'busca-submit'));
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-busca'));
        //atributos ocultos
        $cidade_hidden = new \Zend\Form\Element\Hidden('cidade-hidden');
        $cidade_hidden->setAttribute('class', 'cidade-hidden');
        $bairro_hidden = new \Zend\Form\Element\Hidden('bairro-hidden');
        $bairro_hidden->setAttribute('class', 'bairro-hidden');
        $tipo_hidden = new \Zend\Form\Element\Hidden('tipo-hidden');
        $tipo_hidden->setAttribute('class', 'tipo-hidden');
        $finalidade_hidden = new \Zend\Form\Element\Hidden('tansacao-hidden');
        $finalidade_hidden->setAttribute('class', 'transacao-hidden');
        $valor_hidden = new \Zend\Form\Element\Hidden('valor-hidden');
        $valor_hidden->setAttribute('class', 'valor-hidden');
        //adicionando elementos
        $this->add($cidade);
        $this->add($cidade_hidden);
        $this->add($bairro);
        $this->add($bairro_hidden);
        $this->add($tipo);
        $this->add($tipo_hidden);
        $this->add($finalidade);
        $this->add($finalidade_hidden);
        $this->add($valor);
        $this->add($valor_hidden);
        $this->add($submit);
    }
}