<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of AdminController
 *
 * @author thiago
 */

namespace Site\Controller;

use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Site\Form\Index\busca as form_busca;


class SiteController extends \Base\Controller\BaseController{
    private $_imovelDao;
    protected static $_qtd_por_pagina=4;
    public function __construct() {
        parent::__construct();
        $this->_imovelDao = \Base\Model\daoFactory::factory('Imovel');
    }
    
    public function indexAction() {
        parent::indexAction();
        $result = $this->_imovelDao->recuperarAnuncios(null,  self::$_qtd_por_pagina);
        $paginacao = $this->paginador->paginarDados($result,null,  self::$_qtd_por_pagina);
        $partialBarraPaginacao = $this->criarBarraPaginacaoAction($paginacao);  
        $partialListarAnuncios = $this->criarListAction($result);
        $partialBusca = $this->criarBarraDeBuscaAction();
        $this->layout()->busca = $partialBusca;
        $this->layout()->rota = 'front_end/buscarAnuncio';
        $this->setTemplate('/layout/layout');
        $this->appendJavaScript("simob/home.js");
        $view = new ViewModel(array('haDados' => empty($result)? false:true));
        $view->addChild($partialListarAnuncios ,'partialListarAnuncios');
        $view->addChild($partialBarraPaginacao ,'paginacao');
        return $view;
    }
    
    public function proximaPaginaAction(){
       $request = $this->getRequest();
       if($request->isXmlHttpRequest()){
            $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
            /*if($filtro == 'null'){*/
                 $result = $this->_imovelDao->recuperarAnuncios($pagina,self::$_qtd_por_pagina); 
             /*}else{
                 $param = $this->getEvent()->getRouteMatch()->getParam('param');
                 $result = $this->_imovelDao->recuperarAnuncios($pagina,self::$_qtd_por_pagina,$filtro,$param);
             }*/
             $paginacao = $this->paginador->paginarDados($result,$pagina,  self::$_qtd_por_pagina);
             $viewModelListar= $this->criarListAction($result);
             $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
             $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
             $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar); 
             $data = array("success" => true,"html" => $html,"barrapaginacao" => $barraPaginacao);
             return $this->getResponse()->setContent(Json_encode($data));
       }
    }
    public function paginaAnteriorAction(){
       $request = $this->getRequest();
       if($request->isXmlHttpRequest()){
            $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
            //if($filtro == 'null'){
                 $result = $this->_imovelDao->recuperarAnuncios($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina); 
             /*}else{
                 $param = $this->getEvent()->getRouteMatch()->getParam('param');
                 $result = $this->_imovelDao->recuperarAnuncios($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
             }*/
             $paginacao = $this->paginador->paginarDados($result,$pagina - (self::$_qtd_por_pagina - 1),  self::$_qtd_por_pagina);
             $viewModelListar= $this->criarListAction($result);
             $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
             $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
             $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar); 
             $data = array("success" => true,"html" => $html,"barrapaginacao" => $barraPaginacao);
             return $this->getResponse()->setContent(Json_encode($data));
       }
    }
    
    public function buscarAnuncioAction(){
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){    
            $cidade = $this->getEvent()->getRouteMatch()->getParam('cidade');
            $bairro = $this->getEvent()->getRouteMatch()->getParam('bairro');
            $categoria = $this->getEvent()->getRouteMatch()->getParam('subcategoria');
            $transacao = $this->getEvent()->getRouteMatch()->getParam('transacao');
            $valor = $this->getEvent()->getRouteMatch()->getParam('valor');
            $result = $this->_imovelDao->recuperarAnuncios(null,  self::$_qtd_por_pagina,$cidade,$bairro,$categoria,$transacao,$valor);
            print_r($result);
            $paginacao = $this->paginador->paginarDados($result,null,  self::$_qtd_por_pagina);
            $partialBarraPaginacao = $this->criarBarraPaginacaoAction($paginacao);  
            $partialListarAnuncios = $this->criarListAction($result);
            $data = array("success" => true);
            return $this->getResponse()->setContent(Json_encode($data));
        }
    }
    
     private function criarListAction($anunciosList){
        $lista = new ViewModel(array('imoveis_list'=>$anunciosList));
        $lista->setTemplate('site/index/partials/listar.phtml');
        return $lista;
    }
    
     private function criarBarraPaginacaoAction($paginacao){
        $view = new ViewModel(array('paginacao'=>$paginacao,'rota'=>'front_end'));//na view $rota.'proximaPagina'
        $view->setTemplate('application/partials/paginacao.phtml');
        return $view;
    }
    
     private function criarBarraDeBuscaAction(){//passando os params para o application/src/form
        $cidades  = $this->Localidades()->getCidades("RJ");
        $busca = new form_busca();//1- primeiro eu instancio o formularioarray('selecione'=>'selecione','nome' => 'nome','cidade' => 'cidade')
        $busca->get('cidade')->setAttribute('options',$cidades);
        $busca->get('bairro')->setAttribute('options', array(0=>'Selecione uma Cidade'));
        //
        $categoriaDao = \Base\Model\daoFactory::factory('SubCategoriaImovel');
        $dadosCategoria = $categoriaDao->recuperarTodos();
        $categorias = $this->SelectHelper()->getArrayData("selecione",$dadosCategoria);
        $busca->get('tipo')->setAttribute('options', $categorias);
        //
        $transacaoDao = \Base\Model\daoFactory::factory('TipoTransacao');
        $dadosTransacoes = $transacaoDao->recuperarTodos();
        $transacoes = $this->SelectHelper()->getArrayData("selecione",$dadosTransacoes);
        $busca->get('transacao')->setAttribute('options', $transacoes);
        //
        $arrayPreco = array(array("value"=>0, "label"=>"selecione", "disabled" => "disabled", "selected" => "selected"),array("value" => 1, "label" => "R$ 100.000 a R$ 200.000"),array("value" => 2, "label" => "R$ 200.000 a R$ 300.000"),array("value" => 3, "label" => "R$ 300.000 a R$ 400.000"),array("value" => 4, "label" => "R$ 400.000 a R$ 500.000"),array("value" => 5, "label" => "acima de R$ 500.000"));
        $busca->get('valor')->setAttribute('options', $arrayPreco);
        return $busca;
    }
}


