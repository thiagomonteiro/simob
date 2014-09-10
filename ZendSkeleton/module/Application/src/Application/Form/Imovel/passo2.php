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
        $this->setAttributes(array('class' => 'formulario2', 'id' => 'form-passo2'));
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo1-submit'));
        $checkQuarto = new \Zend\Form\Element\Checkbox('checkQuarto');
        $checkQuarto->setAttribute('class', 'check-quarto')->setAttributes(array("for" => "checkQuarto"));
        $checkQuarto->setLabel('Quarto');
        $checkQuarto->setUseHiddenElement(true);
        $checkQuarto->setCheckedValue(true);
        $checkQuarto->setUncheckedValue(false);
        $qtdQuarto = new \Zend\Form\Element\Number('qtdQuarto');
        $qtdQuarto->setAttribute('class', 'qtd-quarto');
        $qtdQuarto->setAttribute('value', 0);
        $qtdQuarto->setLabel('Quantidade');
        
        $checkSala = new \Zend\Form\Element\Checkbox('check-sala');
        $checkSala->setLabel('Sala');
        $checkSala->setUseHiddenElement(true);
        $checkSala->setCheckedValue(true);
        $checkSala->setUncheckedValue(false);
        $qtdSala = new \Zend\Form\Element\Number('qtd-sala');
        $qtdSala->setAttribute('value', 0);
        $qtdSala->setLabel("Quantidade");
        
        $checkBanheiro = new \Zend\Form\Element\Checkbox('check-banheiro');
        $checkBanheiro->setLabel('Banheiro');
        $checkBanheiro->setUseHiddenElement(true);
        $checkBanheiro->setCheckedValue(true);
        $checkBanheiro->setUncheckedValue(false);
        $qtdBanheiro =  new \Zend\Form\Element\Number('qtd-banheiro');
        $qtdBanheiro->setAttribute('value', 0);
        $qtdBanheiro->setLabel("Quantidade");
     
        $checkCozinha = new \Zend\Form\Element\Checkbox('check-cozinha');
        $checkCozinha->setLabel('Cozinha');
        $checkCozinha->setUseHiddenElement(true);
        $checkCozinha->setCheckedValue(true);
        $checkCozinha->setUncheckedValue(false);
        $qtdCozinha =  new \Zend\Form\Element\Number('qtd-cozinha');
        $qtdCozinha->setAttribute('value', 0);
        $qtdCozinha->setLabel("Quantidade");
        
        $checkGaragem = new \Zend\Form\Element\Checkbox('check-garagem');
        $checkGaragem->setLabel('Garagem');
        $checkGaragem->setUseHiddenElement(true);
        $checkGaragem->setCheckedValue(true);
        $checkGaragem->setUncheckedValue(false);
        $qtdGaragem =  new \Zend\Form\Element\Number('qtd-garagem');
        $qtdGaragem->setAttribute('value', 0);
        $qtdGaragem->setLabel("Quantidade");
        
        $checkVaranda = new \Zend\Form\Element\Checkbox('check-varanda');
        $checkVaranda->setLabel('Varanda');
        $checkVaranda->setUseHiddenElement(true);
        $checkVaranda->setCheckedValue(true);
        $checkVaranda->setUncheckedValue(false);
        $qtdVaranda =  new \Zend\Form\Element\Number('qtd-varanda');
        $qtdVaranda->setAttribute('value', 0);
        $qtdVaranda->setLabel("Quantidade");
        
        $checkSuite = new \Zend\Form\Element\Checkbox('check-suite');
        $checkSuite->setLabel('Suíte');
        $checkSuite->setUseHiddenElement(true);
        $checkSuite->setCheckedValue(true);
        $checkSuite->setUncheckedValue(false);
        $qtdSuite =  new \Zend\Form\Element\Number('qtd-suite');
        $qtdSuite->setAttribute('value', 0);
        $qtdSuite->setLabel("Quantidade");
        
        $checkQempregada = new \Zend\Form\Element\Checkbox('check-q-empregada');
        $checkQempregada->setLabel('Q. Empr.');
        $checkQempregada->setUseHiddenElement(true);
        $checkQempregada->setCheckedValue(true);
        $checkQempregada->setUncheckedValue(false);
        $qtdQempregada =  new \Zend\Form\Element\Number('qtd-q-empregada');
        $qtdQempregada->setAttribute('value', 0);
        $qtdQempregada->setLabel("Quantidade");
        
        $checkAservico = new \Zend\Form\Element\Checkbox('check-a-servico');
        $checkAservico->setLabel('Area Serv.');
        $checkAservico->setUseHiddenElement(true);
        $checkAservico->setCheckedValue(true);
        $checkAservico->setUncheckedValue(false);
        $qtdAservico =  new \Zend\Form\Element\Number('qtd-a-servico');
        $qtdAservico->setAttribute('value', 0);
        $qtdAservico->setLabel("Quantidade");
        
        $checkTerraco = new \Zend\Form\Element\Checkbox('check-terraco');
        $checkTerraco->setLabel('Terraço');
        $checkTerraco->setUseHiddenElement(true);
        $checkTerraco->setCheckedValue(true);
        $checkTerraco->setUncheckedValue(false);
        $qtdTerraco =  new \Zend\Form\Element\Number('qtd-terraco');
        $qtdTerraco->setAttribute('value', 0);
        $qtdTerraco->setLabel("Quantidade");
        
        $checkEscritorio = new \Zend\Form\Element\Checkbox('check-escritorio');
        $checkEscritorio->setLabel('Escritório');
        $checkEscritorio->setUseHiddenElement(true);
        $checkEscritorio->setCheckedValue(true);
        $checkEscritorio->setUncheckedValue(false);
        $qtdEscritorio =  new \Zend\Form\Element\Number('qtd-escritorio');
        $qtdEscritorio->setAttribute('value', 0);
        $qtdEscritorio->setLabel("Quantidade");
        
        $checkDespensa = new \Zend\Form\Element\Checkbox('check-despensa');
        $checkDespensa->setLabel('Despensa');
        $checkDespensa->setUseHiddenElement(true);
        $checkDespensa->setCheckedValue(true);
        $checkDespensa->setUncheckedValue(false);
        $qtdDespensa =  new \Zend\Form\Element\Number('qtd-despensa');
        $qtdDespensa->setAttribute('value', 0);
        $qtdDespensa->setLabel("Quantidade");
        
        $checkCloset = new \Zend\Form\Element\Checkbox('check-closet');
        $checkCloset->setLabel('Closet');
        $checkCloset->setUseHiddenElement(true);
        $checkCloset->setCheckedValue(true);
        $checkCloset->setUncheckedValue(false);
        $qtdCloset =  new \Zend\Form\Element\Number('qtd-closet');
        $qtdCloset->setAttribute('value', 0);
        $qtdCloset->setLabel("Quantidade");
        
        $proprietario_txt = new \Zend\Form\Element\Text("txt-proprietario");
        $proprietario_txt->setLabel("Proprietario");
        $proprietario_btn = new \Zend\Form\Element\Button("btn-proprietario");
        $proprietario_btn->setLabel("Proprietario");
        
        
        $comodos = new \Zend\Form\Element\Collection('collection');
        $comodos->setAttribute('class', 'fieldcomodos');
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
        $comodos->add($checkSuite);
        $comodos->add($qtdSuite);
        $comodos->add($checkQempregada);
        $comodos->add($qtdQempregada);
        $comodos->add($checkAservico);
        $comodos->add($qtdAservico);
        $comodos->add($checkTerraco);
        $comodos->add($qtdTerraco);
        $comodos->add($checkEscritorio);
        $comodos->add($qtdEscritorio);
        $comodos->add($checkDespensa);
        $comodos->add($qtdDespensa);
        $comodos->add($checkCloset);
        $comodos->add($qtdCloset);
        $this->add($comodos);
        $this->add($proprietario_txt);
        $this->add($proprietario_btn);
        $this->add($submit);
    }
}