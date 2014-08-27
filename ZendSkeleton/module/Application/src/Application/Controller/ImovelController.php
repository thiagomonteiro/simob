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

use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Imovel\passo1 as form_passo1; 
use Application\Filter\Imovel\criarImovel as filtro_criar;
use Application\Session\defaultSession as imovel_session;
class ImovelController extends \Base\Controller\BaseController{
    private $_ImovelDao;
    private $_EstadoDao;
    private $_CidadeDao;
    private $_BairroDao;
    private $_TipoImovelDao;
    private $_SubTipoImovelDao;
    private $_TipoComodosDao;
    private $_TipoTransacaoDao;
    private $_imovel_session;
    /**
     * retorna uma list com os tipos de comodos {sala,quarto,suite,cozinha,garagem}
     */
    public function __construct() {
        parent::__construct();
        $this->_imovel_session = new imovel_session('imovel');
        $this->_ImovelDao = \Base\Model\daoFactory::factory('Imovel');
        $this->_BairroDao = \Base\Model\daoFactory::factory('Bairro');
        $this->_CidadeDao = \Base\Model\daoFactory::factory('Cidade');
        $this->_EstadoDao = \Base\Model\daoFactory::factory('Estado');
        $this->_TipoTransacaoDao = \Base\Model\daoFactory::factory('TipoTransacao');
        
    }
    
   
    public function passo1Action(){
        $request = $this->getRequest();
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->getFormPasso1($params); 
            $Filter = new filtro_criar();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){
               $params['bairro'] = $this->_BairroDao->recuperar($params['bairro']);
               $imovelObj = $this->_ImovelDao->criarNovo($params);
               $this->_imovel_session->salvarObjeto('imovel', $imovelObj);
               $this->flashMessenger()->addSuccessMessage('Passo 1 concluído com sucesso!');
               $this->redirect()->toRoute('crud_imovel/passo2');
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
    
    public function passo2Action(){
        
    }
    
    public function getFormPasso1($dadosPost=array()){
        $operacoes = $this->_TipoTransacaoDao->recuperarTodos();
        $dados_select_operacao = $this->SelectHelper()->getArrayData('selecione uma operação',$operacoes); 
        if(empty($dadosPost)){
            $dados_uf = $this->Localidades()->getEstados();
            $form = new form_passo1();
            $form->get('uf')->setAttribute('options', $dados_uf);
            $form->get('tipoTransacao')->setAttribute('options', $dados_select_operacao);
            $optionsCidade = array(array( 'label' => 'Selecione um Estado','selected' => 'selected', 'disabled' => 'disabled'));
            $optionsBairro = array(array( 'label' => 'Selecione uma Cidade','selected' => 'selected', 'disabled' => 'disabled'));
            $form->get('cidade')->setAttribute('options', $optionsCidade);           
            $form->get('bairro')->setAttribute('options', $optionsBairro);
        }else{  
            $dados_uf = $this->Localidades()->getEstados();
            $form = new form_passo1(null,array(),$dadosPost);
            $form->get('uf')->setAttribute('options', $dados_uf);
            if(empty($dadosPost['uf']) != true){
                $form->get('uf')->setAttribute('selected', $dadosPost['uf']);
                $estado = $this->_EstadoDao->recuperar($dadosPost['uf']);
                $dadosCidade = $this->Localidades()->getCidades($estado->getUf());
                $form->get('cidade')->setAttribute('options', $dadosCidade);
                if(empty($dadosPost['cidade']) != true){
                    $form->get('cidade')->setAttribute('selected', $dadosPost['cidade']);
                    $cidade = $this->_CidadeDao->recuperar($dadosPost['cidade']);
                    $dadosBairro = $this->Localidades()->getBairros($cidade);
                    $form->get('bairro')->setAttribute('options', $dadosBairro);
                    if(empty($dadosPost['bairro']) != true){
                        $form->get('bairro')->setAttribute('selected',$dadosPost['bairro']);
                    }
                }
            } 
            $form->get('tipoTransacao')->setAttribute('options', $dados_select_operacao);
            if(empty($dadosPost['tipoTransacao']) != true){
               $form->get('tipoTransacao')->setAttribute('selected',$dadosPost['tipoTransacao']); 
            }
        }
        return $form;
    }
    
    public function getFormPasso2(){
        
    }
}
