<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Proprietario\criar as form_criar;
use Application\Filter\Proprietario\criarProprietario as filter;

class ProprietarioController extends \Base\Controller\BaseController{
    private $_EstadoDao;
    private $_CidadeDao;
    private $_BairroDao;
    private $_ProprietarioDao;
    
   
    
    private static $_qtd_por_pagina=5;
    
    
    public function __construct() {
        parent::__construct();
        $this->_ProprietarioDao=\Base\Model\daoFactory::factory('Proprietario');
        $this->_EstadoDao = \Base\Model\daoFactory::factory('Estado');
        $this->_CidadeDao = \Base\Model\daoFactory::factory('Cidade');
        $this->_BairroDao = \Base\Model\daoFactory::factory('Bairro');
    }
    
   
    public function indexAction() {
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagem = $this->criarNotificacao($mensagem,'success');
        }
        $listaProprietarios = $this->_ProprietarioDao->recuperarTodos();
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/proprietario.js');
        $view = new ViewModel();
        return $view;
    }


    public function criarAction(){
        $request = $this->getRequest();
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->formCriarProprietarioAction($params); 
            $Filter = new filter();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){
               $params['bairro']=$this->_BairroDao->recuperar($params['bairro']);
               $proprietario_dto = $this->_ProprietarioDao->criarNovo($params);
               $response = $this->_ProprietarioDao->salvar($proprietario_dto);
               $this->flashMessenger()->addSuccessMessage('Proprietario cadastrado com sucesso!');
               $this->redirect()->toRoute('crud_proprietario/index');
            }else{  
               //se der alguma errro 
            }
        }else{
            $form = $this->formCriarProprietarioAction(); 
        }
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/proprietario.js');
        $this->appendJavaScript('libs/maskedinput.js');
        $view = new ViewModel(array('criar'   =>  $form));
        return $view;
    }
    
    private function formCriarProprietarioAction($dadosPost = array()){
        if(empty($dadosPost)){
            $dados_uf = $this->Localidades()->getEstados();
            $form = new form_criar();
            $form->get('uf')->setAttribute('options', $dados_uf);
            $optionsCidade = array(array( 'label' => 'Selecione um Estado','selected' => 'selected', 'disabled' => 'disabled'));
            $optionsBairro = array(array( 'label' => 'Selecione uma Cidade','selected' => 'selected', 'disabled' => 'disabled'));
            $form->get('cidade')->setAttribute('options', $optionsCidade);           
            $form->get('bairro')->setAttribute('options', $optionsBairro);
        }else{
            $dados_uf = $this->Localidades()->getEstados();
            $form = new form_criar(null,array(),$dadosPost);
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
        }
        return $form;
    }
    
    
    }

