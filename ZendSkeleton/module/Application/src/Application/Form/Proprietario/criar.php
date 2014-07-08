<?php

namespace Application\Form\Proprietario;
use Zend\Form\Form;

class criar extends Form{
    public function __construct($name = null, $options = array(),$dados = array()) {
        parent::__construct($name, $options);
        $nome = new \Zend\Form\Element\Text('nome');
        $nome->setLabel('Nome Completo');
        $estado = new \Zend\Form\Element\Select('uf');
        $estado->setAttribute('class','uf-select');
        $estado->setLabel('Estado');
        if (array_key_exists('uf', $dados)) {
            $estado->setAttribute('value', $dados['uf']);
        }
        $estado->setDisableInArrayValidator(true);
        $cidade = new \Zend\Form\Element\Select('cidade');
        $cidade->setAttribute('class', 'cidade-select');
        $cidade->setLabel('Cidade');
        if (array_key_exists('cidade', $dados)) {
            $cidade->setAttribute('value', $dados['cidade']);
        }
        $cidade->setDisableInArrayValidator(true);
        $bairro = new \Zend\Form\Element\Select('bairro');
        $bairro->setAttribute('class', 'bairro-select');
        $bairro->setLabel('Bairro');
        if (array_key_exists('bairro', $dados)) {
            $bairro->setAttribute('value', $dados['bairro']);
        }
        $bairro->setDisableInArrayValidator(true);
        $logradouro = new \Zend\Form\Element\Text('logradouro');
        $logradouro->setLabel('Logradouro');
        $numero = new \Zend\Form\Element\Text('numero');
        $numero->setLabel('Numero');
        $telefone = new \Zend\Form\Element\Text('telefone');
        $telefone->setLabel('Tel Fixo');
        $telefone->setAttribute('class','telefone');
        $celular = new \Zend\Form\Element\Text('celular');
        $celular->setLabel('Celular');
        $celular->setAttribute('class', 'celular');
        $cpf = new \Zend\Form\Element\Text('cpf');
        $cpf->setLabel('CPF');
        $cpf->setAttribute('class', 'cpf');
        $rg = new \Zend\Form\Element\Text('rg');
        $rg->setLabel('RG');
        $profissao = new \Zend\Form\Element\Text('profissao');
        $profissao->setLabel('Profissão');
        $this->setAttributes(array('class' => 'formulario', 'id' => 'form-proprietario-criar'));
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttributes(array('value'=>'salvar','id'=>'proprietario-submit'));
        $this->add($nome);
        $this->add($estado);
        $this->add($cidade);
        $this->add($bairro);
        $this->add($logradouro);
        $this->add($numero);
        $this->add($telefone);
        $this->add($celular);
        $this->add($cpf);
        $this->add($rg);
        $this->add($profissao);
        $this->add($submit);
    }
}
?>