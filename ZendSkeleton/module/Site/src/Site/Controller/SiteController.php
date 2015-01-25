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
        $partialBusca = $this->criarBarraDeBuscaAction('front_end');
        $this->layout()->busca = $partialBusca;
        $this->setTemplate('/layout/layout');
        $this->appendJavaScript("simob/home.js");
        $view = new ViewModel(array('haDados' => empty($result)? false:true));
        $view->addChild($partialListarAnuncios ,'partialListarAnuncios');
        $view->addChild($partialBarraPaginacao ,'paginacao');
        return $view;
    }
    
    public function proximaPaginaAction(){
       $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
       $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro'); 
       if($filtro == 'null'){
            $result = $this->_imovelDao->recuperarAnuncios($pagina,self::$_qtd_por_pagina); 
        }else{
            $param = $this->getEvent()->getRouteMatch()->getParam('param');
            $result = $this->_imovelDao->recuperarAnuncios($pagina,self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($result,$pagina,  self::$_qtd_por_pagina);
        $viewModelListar= $this->criarListAction($result);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar); 
        $data = array("success" => true,"html" => $html,"barrapaginacao" => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    public function paginaAnteriorAction(){
       $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
       $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro'); 
       if($filtro == 'null'){
            $result = $this->_imovelDao->recuperarAnuncios($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina); 
        }else{
            $param = $this->getEvent()->getRouteMatch()->getParam('param');
            $result = $this->_imovelDao->recuperarAnuncios($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($result,$pagina - (self::$_qtd_por_pagina - 1),  self::$_qtd_por_pagina);
        $viewModelListar= $this->criarListAction($result);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar); 
        $data = array("success" => true,"html" => $html,"barrapaginacao" => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
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
    
     private function criarBarraDeBuscaAction($rota){//passando os params para o application/src/form
        $cidades  = $this->Localidades()->getCidades("RJ");
        $busca = new form_busca();//1- primeiro eu instancio o formularioarray('selecione'=>'selecione','nome' => 'nome','cidade' => 'cidade')
        $busca->get('cidade')->setAttribute('options',$cidades);
        //$view = new ViewModel(array('rota' => $rota,'busca'=>$busca));
        //$view->setTemplate('site/index/partials/busca.phtml');
        return $busca;
    }
}


