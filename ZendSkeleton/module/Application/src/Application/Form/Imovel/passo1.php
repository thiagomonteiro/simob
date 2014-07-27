<?php

namespace Application\Form\Imovel;
use Zend\Form\Form;
class passo1 extends Form{
    public function __construct($name = null, $options = array(),$dados = array()) {
        parent::__construct($name, $options);
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-passo1'));
        $estado = new \Zend\Form\Element\Select('uf-imovel');
        $estado->setLabel('Estado');
        $estado->setDisableInArrayValidator(true);
        $cidade = new \Zend\Form\Element\Select('cidade-imovel');
        $cidade->setLabel('Cidade');
        $cidade->setDisableInArrayValidator(true);
        $bairro = new \Zend\Form\Element\Select('bairro-imovel');
        $bairro->setLabel('Bairro');
        $bairro->setDisableInArrayValidator(true);
        $endereco = new \Zend\Form\Element\Text('rua');
        $endereco->setLabel('Endereço');
        $numero = new \Zend\Form\Element\Text('numero');
        $numero->setLabel('Número');
        $descricao = new \Zend\Form\Element\Textarea('descricao');
        $descricao->setLabel('Descrição');
        $submit = new \Zend\Form\Element\Submit('enviar');
        $area_total = new \Zend\Form\Element\Number('area-total');
        $area_total->setAttribute('value', 0);
        $area_total->setLabel('Área Total');
        $area_construida = new \Zend\Form\Element\Number('area-construida');
        $area_construida->setAttribute('value', 0);
        $area_construida->setLabel('Área Construída');
        $iptu = new \Zend\Form\Element\Text('valor-iptu');
        $iptu->setLabel('IPTU');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo1-submit'));
        $tipo_operacao = new \Zend\Form\Element\Select('tipo-operacao');
        $tipo_operacao->setLabel('Tipo de Operação');
        $preco = new \Zend\Form\Element\Text('valor-operacao');
        $preco->setLabel('Valor da Operação');
        $this->add($estado);
        $this->add($cidade);
        $this->add($bairro);
        $this->add($endereco);
        $this->add($numero);
        $this->add($descricao);
        $this->add($area_total);
        $this->add($area_construida);
        $this->add($iptu); 
        $this->add($tipo_operacao);
        $this->add($preco);
        
        
        $this->add($submit);
    }
}