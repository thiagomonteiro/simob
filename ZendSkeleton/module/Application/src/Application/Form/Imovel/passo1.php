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
        $area_total = new \Zend\Form\Element\Number('areaTotal');
        $area_total->setAttribute('value', 0);
        $area_total->setLabel('Área Total');
        $area_construida = new \Zend\Form\Element\Number('areaConstruida');
        $area_construida->setAttribute('value', 0);
        $area_construida->setLabel('Área Construída');
        $iptu = new \Zend\Form\Element\Text('valorIptu');
        $iptu->setLabel('IPTU');
        $iptu->setAttribute('class', 'iptu');
        $submit->setAttributes(array('value'=>'Salvar e Continuar','id'=>'passo1-submit'));
        $tipo_operacao = new \Zend\Form\Element\Select('tipoTransacao');
        $tipo_operacao->setLabel('Tipo de Operação');
        if (array_key_exists('tipoTransacao', $dados)) {
            $estado->setAttribute('value', $dados['tipoTransacao']);
        }
        $tipo_operacao->setDisableInArrayValidator(true);
        $categoria_imovel = new \Zend\Form\Element\Select('categoria');
        $categoria_imovel->setAttribute('class', 'categoria-select');
        $categoria_imovel->setLabel('Categoria');
        $categoria_imovel->setDisableInArrayValidator(true);
        $sub_categoria_imovel = new \Zend\Form\Element\Select('subCategoria');
        $sub_categoria_imovel->setAttribute('class', 'sub-categoria-select');
        $sub_categoria_imovel->setLabel('SubCategoria');
        $sub_categoria_imovel->setDisableInArrayValidator(true);
        $preco = new \Zend\Form\Element\Text('valorTransacao');
        $preco->setAttribute('class', 'preco');
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
        $this->add($categoria_imovel);
        $this->add($sub_categoria_imovel);
        $this->add($submit);
    }
}