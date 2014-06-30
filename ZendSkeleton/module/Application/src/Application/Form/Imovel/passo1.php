<?php

namespace Application\Form\Imovel;
use Zend\Form\Form;
class passo1 extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->setAttributes(array('class' => 'formulario-passo1', 'id' => 'form-passo1'));
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo1-submit'));
        $this->add($this->getSelectsFieldSet());
        $this->add($this->getEnderecoFieldSet());
        $this->add($this->getMedidasFieldSet());
        $this->add($this->getFinanceiroFieldSet());
        $this->add($submit);
    }
    
    private function getSelectsFieldSet(){
        $selects_field = new \Zend\Form\Fieldset('selects-fieldSet');
        $selects_field->setLabel("Localizacao");
        $estado = new \Zend\Form\Element\Select('select-imovel-uf');
        $estado->setLabel('Estado');
        $cidade = new \Zend\Form\Element\Select('select-imovel-cidade');
        $cidade->setLabel('Cidade');
        $bairro = new \Zend\Form\Element\Select('select-imovel-bairro');
        $bairro->setLabel('bairro');
        $selects_field->add($estado);
        $selects_field->add($cidade);
        $selects_field->add($bairro);
        return $selects_field;
    }
    
    private function getEnderecoFieldSet(){
        $endereco_field = new \Zend\Form\Fieldset('endereco-fieldSet');
        $endereco_field->setLabel("Logradouro");
        $endereco = new \Zend\Form\Element\Text('rua');
        $endereco->setLabel('Endereço');
        $numero = new \Zend\Form\Element\Text('numero');
        $numero->setLabel('Número');
        $descricao = new \Zend\Form\Element\Textarea('descricao');
        $descricao->setLabel('Descrição');
        $endereco_field->add($endereco);
        $endereco_field->add($numero);
        $endereco_field->add($descricao);
        return $endereco_field;
    }
    
    private function getMedidasFieldSet(){
        $medidas_field = new \Zend\Form\Fieldset('medidas-fieldSet');
        $medidas_field->setLabel("Sobre o Imovel");
        $area_total = new \Zend\Form\Element\Number('area-total');
        $area_total->setAttribute('value', 0);
        $area_total->setLabel('Área Total');
        $area_construida = new \Zend\Form\Element\Number('area-construida');
        $area_construida->setAttribute('value', 0);
        $area_construida->setLabel('Área Construída');
        $iptu = new \Zend\Form\Element\Text('valor-iptu');
        $iptu->setLabel('IPTU');
        $medidas_field->add($area_total);
        $medidas_field->add($area_construida);
        $medidas_field->add($iptu); 
        return $medidas_field;
    }
    
    private function getFinanceiroFieldSet(){
        $financeiro_field = new \Zend\Form\Fieldset('transacao-fieldSet');
        $financeiro_field->setLabel('Informações Financeiras');
        $tipo_operacao = new \Zend\Form\Element\Select('tipo-operacao');
        $tipo_operacao->setLabel('Tipo de Operação');
        $preco = new \Zend\Form\Element\Text('valor-operacao');
        $preco->setLabel('Valor da Operação');
        $financeiro_field->add($tipo_operacao);
        $financeiro_field->add($preco);
        return $financeiro_field;
    }
}