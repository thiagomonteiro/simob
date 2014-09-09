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
    public function __construct($name = null, $options = array(), $dados = array()) {
        parent::__construct($name, $options);
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-passo2'));
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo1-submit'));
        
        $checkQuarto = new \Zend\Form\Element\Checkbox('checkQuarto');
        $checkQuarto->setAttribute('class', 'check-quarto');
        $checkQuarto->setLabel('Quarto');
        $checkQuarto->setUseHiddenElement(true);
        $checkQuarto->setCheckedValue(true);
        $checkQuarto->setUncheckedValue(false);
        $qtdQuarto = new \Zend\Form\Element\Number('qtdQuarto');
        $qtdQuarto->setAttribute('class', 'qtd-quarto');
        $qtdQuarto->setAttribute('value', 0);
        $qtdQuarto->setLabel('Quantidade de quartos');
        
        $checkSala = new \Zend\Form\Element\Checkbox('check-sala');
        $checkSala->setLabel('Sala');
        $checkSala->setUseHiddenElement(true);
        $checkSala->setCheckedValue(true);
        $checkSala->setUncheckedValue(false);
        $qtdSala = new \Zend\Form\Element\Number('qtd-sala');
        $qtdSala->setAttribute('value', 0);
        $qtdSala->setLabel("Quantidade de salas");
        
        $checkBanheiro = new \Zend\Form\Element\Checkbox('check-banheiro');
        $checkBanheiro->setLabel('Banheiro');
        $checkBanheiro->setUseHiddenElement(true);
        $checkBanheiro->setCheckedValue(true);
        $checkBanheiro->setUncheckedValue(false);
        $qtdBanheiro =  new \Zend\Form\Element\Number('qtd-banheiro');
        $qtdBanheiro->setAttribute('value', 0);
        $qtdBanheiro->setLabel("Quantidade de Banheiros");
     
        $checkCozinha = new \Zend\Form\Element\Checkbox('check-cozinha');
        $checkCozinha->setLabel('Cozinha');
        $checkCozinha->setUseHiddenElement(true);
        $checkCozinha->setCheckedValue(true);
        $checkCozinha->setUncheckedValue(false);
        $qtdCozinha =  new \Zend\Form\Element\Number('qtd-cozinha');
        $qtdCozinha->setAttribute('value', 0);
        $qtdCozinha->setLabel("Quantidade de Cozinhas");
        
        $checkGaragem = new \Zend\Form\Element\Checkbox('check-garagem');
        $checkGaragem->setLabel('Garagem');
        $checkGaragem->setUseHiddenElement(true);
        $checkGaragem->setCheckedValue(true);
        $checkGaragem->setUncheckedValue(false);
        $qtdGaragem =  new \Zend\Form\Element\Number('qtd-garagem');
        $qtdGaragem->setAttribute('value', 0);
        $qtdGaragem->setLabel("Quantidade de Garagens");
        
        $checkVaranda = new \Zend\Form\Element\Checkbox('check-varanda');
        $checkVaranda->setLabel('Varanda');
        $checkVaranda->setUseHiddenElement(true);
        $checkVaranda->setCheckedValue(true);
        $checkVaranda->setUncheckedValue(false);
        $qtdVaranda =  new \Zend\Form\Element\Number('qtd-varanda');
        $qtdVaranda->setAttribute('value', 0);
        $qtdVaranda->setLabel("Quantidade de Varandas");
        
        $comodos = new \Zend\Form\Element\Collection('collection');
        $comodos->setLabel('Cômodos');
        $comodos->setCount(2);
        $comodos->add($checkQuarto);
        $comodos->add($qtdQuarto);
        $comodos->add($checkSala);
        $comodos->add($qtdSala);
        $comodos->add($checkBanheiro);
        $comodos->add($qtdBanheiro); 
        $comodos->add($checkCozinha);
        $comodos->add($qtdCozinha);
        $comodos->add($checkGaragem);
        $comodos->add($qtdGaragem);
        $comodos->add($checkVaranda);
        $comodos->add($qtdVaranda);
        $this->add($comodos);
        $this->add($submit);
    }
}
