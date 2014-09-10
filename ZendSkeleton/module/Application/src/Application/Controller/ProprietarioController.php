<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Proprietario\busca as form_busca;
use Application\Form\Proprietario\criar as form_criar;
use Application\Form\Proprietario\alterar as form_alterar;
use Application\Filter\Proprietario\criarProprietario as filter_criar;
use Application\Filter\Proprietario\alterarProprietario as filter_alterar;

class ProprietarioController extends \Base\Controller\BaseController{
    private $_EstadoDao;
    private $_CidadeDao;
    private $_BairroDao;
    private $_ProprietarioDao;

    
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
        $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro');
        $param = $this->getEvent()->getRouteMatch()->getParam('param');
        $result = $this->_ProprietarioDao->recuperarTodos(null,  self::$_qtd_por_pagina);
        $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);
        $partialLista = $this->GetViewLista($result);
        $partialPaginacao = $this->GetViewBarraPaginacao($paginacao);
        $partialBusca = $this->GetViewBarraDeBusca('crud_proprietario/buscar',$param);
        $view = new ViewModel(array('haDados' => empty($result)? false:true));
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/proprietario.js');
        $view->addChild($partialLista , 'tableList');
        $view->addChild($partialPaginacao,'paginacao');
        $view->addChild($partialBusca, 'busca');
        return $view;
    }
    
     public function proximaPaginaAction(){
        //somente requisições ajax        
        $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro');
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
        if($filtro == null){
            $proprietariosList = $this->_ProprietarioDao->recuperarTodos($pagina,self::$_qtd_por_pagina);   
        }else{            
            $proprietariosList = $this->_ProprietarioDao->recuperarPorParametro($pagina,self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($proprietariosList,$pagina,self::$_qtd_por_pagina);
        $viewModelListar= $this->GetViewLista($proprietariosList);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
        $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function paginaAnteriorAction(){
        //somente requisições ajax
        $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro');
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
        if($filtro == null){
            $proprietariosList = $this->_ProprietarioDao->recuperarTodos($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
        }else{
            $proprietariosList = $this->_ProprietarioDao->recuperarPorParametro($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($proprietariosList,$pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
        $viewModelListar= $this->GetViewLista($proprietariosList);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
        $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function buscarAction(){
        $request = $this->getRequest();//2- pego a requisiçao
        if($request->isPost()){//3-verifico se é um post se for:
            $params = $request->getPost()->toArray();
        }
        $param = $params['hidden-param'];
        $filtro = $params['hidden-filtro'];
        $result = $this->_ProprietarioDao->recuperarPorParametro(null,self::$_qtd_por_pagina,$filtro,$param);
        $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);
        $viewModelListar= $this->GetViewLista($result);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
        $data = array('success' => true,'haDados' => !empty($result),'html' => $html, 'barrapaginacao' => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function deletarAction(){
        try{
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
            $response = $this->_ProprietarioDao->remover($id);
            $data = array('success' => true,'menssagem'=>'Registro removido com sucesso');
        } catch (Exception $e) {
            $data = array('success' => false,'mensagem' => 'ocorreu uma falha, repita a operação caso o problema persita contacte o Administrador do sistema');
        }
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function alterarAction(){
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $form = $this->GetFormAlterar($id);
        $viewModel = $this->getServiceLocator()->get('ViewRenderer')->render($form);
        $data = array('success' => true,'html'=>$viewModel);
        return $this->getResponse()->setContent(Json_encode($data));     
    }
    
    public function salvarAlteracoesAction(){
        $request = $this->getRequest();
        if($request->isPost()){
            $dados = (array)$request->getPost();
            $validador = new filter_alterar();
            $inputFilter = $validador->getInputFilter();
            $inputFilter->setData($dados);
            if($inputFilter->isValid()){
                $dados['bairro']=$this->_BairroDao->recuperar($dados['bairro']);
                $proprietarioOBJ = $this->_ProprietarioDao->criarNovo($dados);
                $proprietarioOBJ->setPersistido(true);
                $resposta = $this->_ProprietarioDao->salvar($proprietarioOBJ);
                $data = array('success' => true,'menssagem'=>'Dados alterados com sucesso');
            }else{
                $data = array('success'=>false,'erros'=>$inputFilter->getMessages());
            }
        }
        return $this->getResponse()->setContent(json_encode($data));
    }
    
    private function GetFormAlterar($id){
        $proprietarioObj = $this->_ProprietarioDao->recuperar($id);
        $uf =  $proprietarioObj->getBairro()->getCidade()->getEstado(); 
        $dados_uf = $this->Localidades()->getEstados();
        unset($dados_uf[0]);
        $dados_uf[$uf->getId()]["selected"]="selected";
        $cidade = $proprietarioObj->getBairro()->getCidade();
        $dados_cidade = $this->Localidades()->getCidades($uf->getUf());        
        $dados_cidade[$cidade->getId()]["selected"]="selected";
        $bairro = $proprietarioObj->getBairro();
        $dados_bairro = $this->Localidades()->getBairros($cidade);
        $dados_bairro[$bairro->getId()]["selected"]="selected";
        $form = new form_alterar();
        $form->get('id')->setAttribute('value', $id);       
        $form->get('nome')->setAttribute('value', $proprietarioObj->getNome());
        $form->get('uf')->setAttribute('options', $dados_uf);
        $form->get('cidade')->setAttribute('options', $dados_cidade);
        $form->get('bairro')->setAttribute('options', $dados_bairro);
        $form->get('logradouro')->setAttribute('value', $proprietarioObj->getLogradouro());
        $form->get('numero')->setAttribute('value', $proprietarioObj->getNumero());
        $form->get('telefone')->setAttribute('value', $proprietarioObj->getTelefone());
        $form->get('celular')->setAttribute('value', $proprietarioObj->getCelular());        
        $form->get('rg')->setAttribute('value', $proprietarioObj->getRg());
        $form->get('profissao')->setAttribute('value', $proprietarioObj->getProfissao());
        $view = new ViewModel(array('alterar'   =>  $form));
        $view->setTemplate('application/proprietario/alterar.phtml');
        return $view;
    }
    
    public function criarAction(){
        $request = $this->getRequest();
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->formCriarProprietarioAction($params); 
            $Filter = new filter_criar();
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
    
    private function GetViewLista($proprietariosList){
        $view= new ViewModel(array('proprietarios'=>$proprietariosList));
        $view->setTemplate('application/proprietario/partials/lista.phtml');
        return $view;
    }
    
    private function GetViewBarraPaginacao($paginacao){
        $view = new ViewModel(array('paginacao'=>$paginacao,'rota'=>'crud_proprietario'));//na view $rota.'proximaPagina'
        $view->setTemplate('application/partials/paginacao.phtml');
        return $view;
    }
    
     private function GetViewBarraDeBusca($rota,$param){//passando os params para o application/src/form
        $busca = new form_busca(null,array(),$param);//1- primeiro eu instancio o formulario
        $busca->get('filtro')->setAttribute('options',array('selecione'=>'selecione','nome' => 'nome','cpf' => 'cpf'));
        $view = new ViewModel(array('rota' => $rota, 'busca' => $busca));
        $view->setTemplate('application/proprietario/partials/busca.phtml');
        return $view;
    } 
    
    }
