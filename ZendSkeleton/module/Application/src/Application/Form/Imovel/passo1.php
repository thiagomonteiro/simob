<?php

namespace Application\Form\Imovel;
use Zend\Form\Form;
class passo1 extends Form{
    public function __construct($name = null, $options = array(),$dados = array()) {
        parent::__construct($name, $options);
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-passo1'));
        $estado = new \Zend\Form\Element\Select('uf');
        $estado->setAttribute('class','uf-select');
        $estado->setLabel('Estado');
        if (array_key_exists('uf', $dados)) {
            $estado->setAttribute('value', $dados['uf']);
        }
        $estado->setDisableInArrayValidator(true);
        $cidade = new \Zend\Form\Element\Select('cidade');
        $cidade->setAttribute('class','cidade-select');
        $cidade->setLabel('Cidade');
         if (array_key_exists('cidade', $dados)) {
            $estado->setAttribute('value', $dados['cidade']);
        }
        $cidade->setDisableInArrayValidator(true);
        $bairro = new \Zend\Form\Element\Select('bairro');
        $bairro->setAttribute('class','bairro-select');
        $bairro->setLabel('Bairro');
         if (array_key_exists('bairro', $dados)) {
            $estado->setAttribute('value', $dados['bairro']);
        }
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
        $iptu = new \Zend\Form\Element\Number('valor-iptu');
        $iptu->setLabel('IPTU');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo1-submit'));
        $tipo_operacao = new \Zend\Form\Element\Select('tipo-operacao');
        $tipo_operacao->setLabel('Tipo de Operação');
        if (array_key_exists('tipo-operacao', $dados)) {
            $estado->setAttribute('value', $dados['tipo-operacao']);
        }
        $tipo_operacao->setDisableInArrayValidator(true);
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