<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Imovel;
use Zend\Form\Form;
/**
 * Description of passo2
 *
 * @author administrador
 */
class alterarPasso2 extends Form{
    public function __construct($name = null, $options = array(),$dados = array(), \Application\Entity\Imovel $imovel=null) {
        parent::__construct($name, $options);
        $this->setAttributes(array('class' => 'formulario2', 'id' => 'form-passo2'));
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo2-submit')); 
        $proprietario_id = new \Zend\Form\Element\Hidden("idProprietario");
        $proprietario_id->setAttribute("class", "id-proprietario");
        $proprietario_txt = new \Zend\Form\Element\Text("proprietario");
        $proprietario_txt->setAttribute('class', "txt-proprietario");
        $proprietario_txt->setLabel("proprietario");
        $proprietario_txt->setAttribute('readonly', 'readonly');
        $proprietario_btn = new \Zend\Form\Element\Button("btnProprietario");
        $proprietario_btn->setAttribute('class', "btn-proprietario");
        $proprietario_btn->setLabel("Proprietario");
        $this->add($proprietario_id);
        $this->add($proprietario_txt);
        $this->add($proprietario_btn);
        $this->add($submit);
    }
}