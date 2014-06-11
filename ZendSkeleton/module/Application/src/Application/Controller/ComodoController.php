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
use Application\Form\Comodo\busca as form_busca;
use Application\Form\Comodo\alterar as form_alterar;
use Application\Form\Comodo\criar as form_criar;
use Application\Filter\Comodo\criarComodo as comodo_filter;

class ComodoController extends \Base\Controller\BaseController{
    private $ComodoDao;
    private static $_qtd_por_pagina=5;
    /**
     * retorna uma list com os tipos de comodos {sala,quarto,suite,cozinha,garagem}
     */
    public function __construct() {
        parent::__construct();
        $this->ComodoDao=\Base\Model\daoFactory::factory('Comodo');
    }
    
    public function indexAction(){    
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagem = $this->criarNotificacao($mensagem,'success');
        }        
        $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro');
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        if($filtro == null){
            $result = $this->ComodoDao->recuperarTodos(null,  self::$_qtd_por_pagina);
        }else{
            $result = $this->ComodoDao->recuperarTodos(null,  self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);
        $partialLista = $this->GetViewLIsta($result);
        $partialPaginacao = $this->GetViewBarraPaginacao($paginacao);
        $partialBusca = $this->GetViewBarraDeBusca('crud_comodo/buscar',$param);
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/comodo.js');
        $view = new ViewModel(array('haDados' => empty($result)? false:true));
        $view->addChild($partialLista , 'tableList');
        $view->addChild($partialPaginacao,'paginacao');
        $view->addChild($partialBusca,'busca');
        return $view;
    }
    
    private function GetViewLIsta($comodosList){
        $view= new ViewModel(array('comodos'=>$comodosList));
        $view->setTemplate('application/comodo/partials/lista.phtml');
        return $view;
    }
    
    private function GetViewBarraPaginacao($paginacao){
        $view = new ViewModel(array('paginacao'=>$paginacao,'rota'=>'crud_comodo'));//na view $rota.'proximaPagina'
        $view->setTemplate('application/partials/paginacao.phtml');
        return $view;
    }
    
    private function GetViewBarraDeBusca($rota,$param){//passando os params para o application/src/form
        $busca = new form_busca(null,array(),$param);//1- primeiro eu instancio o formulario
        $view = new ViewModel(array('rota' => $rota, 'busca' => $busca));
        $view->setTemplate('application/comodo/partials/busca.phtml');
        return $view;
    }
    
    public function GetFormAlterar(){
        $form = new form_alterar();//1- primeiro eu instancio o formulario
        $view = new ViewModel(array('alterar'   =>  $form));
        $view->setTemplate('application/comodo/alterar.phtml');
        return $view;
    }
    
    public function buscarAction(){
            $request = $this->getRequest();//2- pego a requisiçao
            if($request->isPost()){//3-verifico se é um post se for:
                $params = $request->getPost()->toArray();
            }           
            $param = $params['param'];
            $result = $this->ComodoDao->recuperarPorParametro(null,self::$_qtd_por_pagina,$param);
            $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);
            $viewModelListar= $this->GetViewLIsta($result);
            $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
            $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
            $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
            $data = array('success' => true,'haDados' => empty($result),'html' => $html, 'barrapaginacao' => $barraPaginacao);
            return $this->getResponse()->setContent(Json_encode($data));
    }
    
     public function proximaPaginaAction(){
        //somente requisições ajax        
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
        if($param == null){
            $result = $this->ComodoDao->recuperarTodos($pagina,self::$_qtd_por_pagina);   
        }else{
            $result = $this->ComodoDao->recuperarPorParametro($pagina,self::$_qtd_por_pagina,$param);
        }
        $paginacao = $this->paginador->paginarDados($result,$pagina,self::$_qtd_por_pagina);
        $viewModelListar= $this->GetViewLIsta($result);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
        $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function paginaAnteriorAction(){
        //somente requisições ajax
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
        if($param == null){
            $result = $this->ComodoDao->recuperarTodos($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
        }else{
            $result = $this->ComodoDao->recuperarPorParametro($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina,$param);
        }
        $paginacao = $this->paginador->paginarDados($result,$pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
        $viewModelListar= $this->GetViewLIsta($result);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
        $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function deletarAction(){
        try{
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
            $response = $this->ComodoDao->remover($id);
            $data = array('success' => true,'menssagem'=>'Registro removido com sucesso');
        } catch (Exception $e) {
            $data = array('success' => false,'mensagem' => 'ocorreu uma falha, repita a operação caso o problema persita contacte o Administrador do sistema');
        }
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function alterarAction(){
        $form = $this->GetFormAlterar();
        $viewModel = $this->getServiceLocator()->get('ViewRenderer')->render($form);
        $data = array('success' => true,'html'=>$viewModel);
        return $this->getResponse()->setContent(Json_encode($data));     
    }
    
    public function salvarAlteracoesAction(){
        $request = $this->getRequest();
        if($request->isPost()){
            $dados = (array)$request->getPost();
            $validador = new comodo_filter();
            $inputFilter = $validador->getInputFilter();
            $inputFilter->setData($dados);
            if($inputFilter->isValid()){
                $comodoOBJ = $this->ComodoDao->criarNovo();
                $comodoOBJ->setId($dados['id']);
                $comodoOBJ->setDescricao($dados['descricao']);
                $comodoOBJ->setPersistido(true);
                $resposta = $this->ComodoDao->salvar($comodoOBJ);
                $data = array('success' => true,'menssagem'=>'Dados alterados com sucesso');
            }else{
                $data = array('success'=>false,'erros'=>$inputFilter->getMessages());

            }
        }
        return $this->getResponse()->setContent(json_encode($data));
    }
    
    public function criarAction(){
        $form = new form_criar();
        $request = $this->getRequest();//2- pego a requisiçao
            if($request->isPost()){//3-verifico se é um post se for:
                $Filter = new comodo_filter();//4- instancio os filtros
                $params = $request->getPost()->toArray();//5- recupero os paramentros que vieram do post
                $form->setData($params);//6a- seto o formulario com os parametros que vieram do post
                $form->setInputFilter($Filter->getInputFilter());//6b- e seto o formulario com o filtro que eu instanciei
                if($form->isValid()){//validação do formulario
                    $dados=(array)$this->getRequest()->getPost();                    
                    $comodoObj = $this->ComodoDao->criarNovo($dados);
                    $response = $this->ComodoDao->salvar($comodoObj);
                    $this->flashMessenger()->addSuccessMessage('comodo cadastrado com sucesso!');
                    $this->redirect()->toRoute('crud_comodo/index');
                }else{  
                   //se der alguma errro 
                }
            }
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/comodo.js');
        $view = new ViewModel(array('criar'   =>  $form));
        return $view;
    }
}
