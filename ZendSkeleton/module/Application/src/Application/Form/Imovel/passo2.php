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
class passo2 extends Form{
    public function __construct($name = null, $options = array(),$dados = array(), $arrayComodos = array()) {
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
        $comodos = new \Zend\Form\Element\Collection('comodos');
        $comodos->setAttribute('class', 'fieldcomodos');
        $comodos->setLabel('Cômodos');
        $comodos->setCount(2);
        if(!empty($arrayComodos)){
            foreach ($arrayComodos as $row){
                $check = new \Zend\Form\Element\Checkbox('check'.$row->getDescricao());
                $check->setAttribute('class', 'check-'.$row->getDescricao())->setAttributes(array("for" => "check".$row->getDescricao()));
                $check->setLabel($row->getDescricao());
                $check->setUseHiddenElement(true);
                $check->setCheckedValue($row->getId());
                $check->setUncheckedValue(false);   
                $comodos->add($check); 
                $qtd = new \Zend\Form\Element\Number('qtd'.$row->getDescricao());
                $qtd->setAttribute('class', 'qtd-'.$row->getDescricao());
                $qtd->setAttribute('value', 0);
                $qtd->setAttribute('min', 0);
                $qtd->setLabel('Quantidade');
                $comodos->add($qtd);
            }
        }else{
            $comodos->setLabel("Nenhum comodo encontrado,Por favor cadastre um comodo!");//exibe uma mensagem dentro do fieldset
            $submit->setAttribute('disabled', 'disabled');//desabilita o botão submit impedindo que o usuario prosiga.
        }
        $this->add($comodos);
        $this->add($proprietario_id);
        $this->add($proprietario_txt);
        $this->add($proprietario_btn);
        $this->add($submit);
    }
}