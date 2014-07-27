<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComodoController
 *
 * @author thiago
 */
namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Imovel\passo1 as form_passo1; 
use Application\Filter\Imovel\criarImovel as filtro_criar;
class ImovelController extends \Base\Controller\BaseController{
    private $_ImovelDao;
    private $_EstadoDao;
    private $_CidadeDao;
    private $_BairroDao;
    private $_TipoImovelDao;
    private $_SubTipoImovelDao;
    private $_TipoComodosDao;
    private $_TipoTransacaoDao;
    
    /**
     * retorna uma list com os tipos de comodos {sala,quarto,suite,cozinha,garagem}
     */
    public function __construct() {
        parent::__construct();
        $this->_ImovelDao=\Base\Model\daoFactory::factory('Imovel');
        $this->_BairroDao=\Base\Model\daoFactory::factory('Bairro');
        $this->_CidadeDao=\Base\Model\daoFactory::factory('Cidade');
        $this->_EstadoDao=\Base\Model\daoFactory::factory('Estado');
    }
    
   
    public function criarAction(){
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js'); 
        $request = $this->getRequest();
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->getFormPasso1($params); 
            $Filter = new filtro_criar();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){
               $params['bairro-imovel']=$this->_BairroDao->recuperar($params['bairro-imovel']);
               $this->flashMessenger()->addSuccessMessage('Proprietario cadastrado com sucesso!');
               $this->redirect()->toRoute('crud_imovel/setComodos');
            }else{  
            }
        }else{
            $form = $this->getFormPasso1(); 
        }
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $view = new ViewModel(array('partialCadastro1'   =>  $form));
        return $view;
    }
    
    public function getFormPasso1($dadosPost=array()){
        //if(empty($dadosPost)){
            $dados_uf = $this->Localidades()->getEstados();
            $form = new form_passo1();
            $form->get('uf-imovel')->setAttribute('options', $dados_uf);
            $optionsCidade = array(array( 'label' => 'Selecione um Estado','selected' => 'selected', 'disabled' => 'disabled'));
            $optionsBairro = array(array( 'label' => 'Selecione uma Cidade','selected' => 'selected', 'disabled' => 'disabled'));
            $form->get('cidade-imovel')->setAttribute('options', $optionsCidade);           
            $form->get('bairro-imovel')->setAttribute('options', $optionsBairro);
        //}else{
            echo 'aki';
            /*$dados_uf = $this->Localidades()->getEstados();
            $form = new form_passo1(null,array(),$dadosPost);
            $form->get('selects-fieldSet')->get('uf-imovel')->setAttribute('options', $dados_uf);
            if(empty($dadosPost['uf-imovel']) != true){
                $form->get('selects-fieldSet')->get('uf-imovel')->setAttribute('selected', $dadosPost['uf']);
                $estado = $this->_EstadoDao->recuperar($dadosPost['uf-imovel']);
                $dadosCidade = $this->Localidades()->getCidades($estado->getUf());
                $form->get('selects-fieldSet')->get('cidade-imovel')->setAttribute('options', $dadosCidade);
                if(empty($dadosPost['cidade-imovel']) != true){
                    $form->get('selects-fieldSet')->get('cidade-imovel')->setAttribute('selected', $dadosPost['cidade-imovel']);
                    $cidade = $this->_CidadeDao->recuperar($dadosPost['cidade-imovel']);
                    $dadosBairro = $this->Localidades()->getBairros($cidade);
                    $form->get('selects-fieldSet')->get('bairro-imovel')->setAttribute('options', $dadosBairro);
                    if(empty($dadosPost['bairro-imovel']) != true){
                        $form->get('selects-fieldSet')->get('bairro-imovel')->setAttribute('selected',$dadosPost['bairro-imovel']);
                    }
                }
            }  */                      
        //}
        return $form;
    }
}
