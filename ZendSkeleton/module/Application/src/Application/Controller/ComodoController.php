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
        $partialBusca = $this->GetViewBarraDeBusca('crud_comodo/buscarComodo',$param);
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
    
    public function buscarComodoAction(){
            $request = $this->getRequest();//2- pego a requisiçao
            if($request->isPost()){//3-verifico se é um post se for:
                $params = $request->getPost()->toArray();
            }
            print_r($params);
            $param = $params['param'];
            $result = $this->ComodoDao->recuperarPorParametro(null,self::$_qtd_por_pagina,$param);
            $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);
            $viewModelListar= $this->criarTabelaAction($result);
            $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
            $viewModelPaginar= $this->GetViewBarraPaginacao($paginacao);
            $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
            $data = array('success' => true,'haDados' => empty($result),'html' => $html, 'barrapaginacao' => $barraPaginacao);
            return $this->getResponse()->setContent(Json_encode($data));
    }
    
    
}
