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
        $this->layout()->rota = 'front_end/buscarAnuncio';
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
    
    public function buscarAnuncioAction(){
        
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
        $arrayPreco = array(1 => "R$ 100.000 a R$ 200.000",2 => "R$ 200.000 a R$ 300.000", 3 => "R$ 300.000 a R$ 400.000", 4 => "R$ 400.000 a R$ 500.000", 5 => "R$ 500.000 ou mais");
        $busca->get('valor')->setAttribute('options', $arrayPreco);
        return $busca;
    }
}


