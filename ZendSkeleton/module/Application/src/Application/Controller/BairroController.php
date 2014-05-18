<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Bairro\criarBairro as form_criar_bairro;
use Application\Filter\Bairro\criarBairro as criar_bairro_filter;
use Application\Form\busca as form_busca;

/**
 * Description of ImovelController
 *
 * @author thiago
 */
class BairroController extends \Base\Controller\BaseController {
    private $BairroDao;
    private static $_qtd_por_pagina=5;
    
    public function __construct() {
        parent::__construct();
        $this->BairroDao=\Base\Model\daoFactory::factory('Bairro');
    }
    
    public function indexAction() {
        parent::indexAction();
    }
    
 
    
    public function gerenciarBairroAction(){  
        $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro');
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        if($filtro == null){
            $result = $this->BairroDao->recuperarTodos(null,self::$_qtd_por_pagina);
        }else{
            $result = $this->BairroDao->recuperarPorParametro(null,self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagem = $this->criarNotificacao($mensagem,'success');
        }        
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/bairro.js');
        $estados = $this->getEstadosAction();
        $partialBusca = $this->criarBarraDeBuscaAction('crud_bairro/gerenciarBairro',$estados,$filtro,$param);
        $partialListarBairros = $this->criarTabelaAction($result);
        $partialBarraPaginacao = $this->criarBarraPaginacaoAction($paginacao);
        $view = new ViewModel(array('haDados' => empty($result)? false:true));
        $view->addChild($partialBusca , 'partialBusca');
        $view->addChild($partialListarBairros ,'partialListarBairros');
        $view->addChild($partialBarraPaginacao ,'paginacao');
        return $view;
    }
    
    
    
    public function proximaPaginaAction(){
        //somente requisições ajax        
        $filtro = $this->getEvent()->getRouteMatch()->getParam('filtro');
        $param = $this->getEvent()->getRouteMatch()->getParam('param');   
        $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
        if($filtro == null){
            $bairrosList = $this->BairroDao->recuperarTodos($pagina,self::$_qtd_por_pagina);   
        }else{
            $bairrosList = $this->BairroDao->recuperarPorParametro($pagina,self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($bairrosList,$pagina,self::$_qtd_por_pagina);
        $viewModelListar= $this->criarTabelaAction($bairrosList);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
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
            $bairrosList = $this->BairroDao->recuperarTodos($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
        }else{
            $bairrosList = $this->BairroDao->recuperarPorParametro($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina,$filtro,$param);
        }
        $paginacao = $this->paginador->paginarDados($bairrosList,$pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
        $viewModelListar= $this->criarTabelaAction($bairrosList);
        $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
        $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
        $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
        $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function criarBairroAction(){
        $form = $this->formCriarBairroAction(); 
        $request = $this->getRequest();//2- pego a requisiçao
            if($request->isPost()){//3-verifico se é um post se for:
                $Filter = new criar_bairro_filter();//4- instancio os filtros
                $params = $request->getPost()->toArray();//5- recupero os paramentros que vieram do post
                $form->setData($params);//6a- seto o formulario com os parametros que vieram do post
                $form->setInputFilter($Filter->getInputFilter());//6b- e seto o formulario com o filtro que eu instanciei
                if($form->isValid()){//validação do formulario
                    $dados=(array)$this->getRequest()->getPost();                    
                    $cidadeDAO = \Base\Model\daoFactory::factory('Cidade');
                    $cidadeOBJ = $cidadeDAO->recuperar($dados['cidade']);        
                    $bairroOBJ = $this->BairroDao->criarNovo();
                    $bairroOBJ->setCidade($cidadeOBJ);
                    $bairroOBJ->setNome($dados['nome']);
                    $resposta = $this->BairroDao->inserir($bairroOBJ);
                    $this->flashMessenger()->addSuccessMessage('bairro cadastrado com sucesso!');
                    $this->redirect()->toRoute('crud_bairro/gerenciarBairro');
                }else{  
                   //se der alguma errro 
                }
            }
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/bairro.js');
        $view = new ViewModel(array('criar'   =>  $form));
        return $view;
    }
    
    public function deletarBairroAction(){
        try{
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
            $response = $this->BairroDao->remover($id);
            $data = array('success' => true);
        } catch (Exception $ex) {
            $data = array('success' => false,'mensagem' => 'ocorreu uma falha, repita a operação caso o problema persita contacte o Administrador do sistema');
        }
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function getCidadesAction(){//funçao que preenche o select-box de cidades        
        $uf = $this->getEvent()->getRouteMatch()->getParam('uf');
        $estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $estado = $estadoDAO->recuperarPorUf($uf);
        $cidadeDAO = \Base\Model\daoFactory::factory('Cidade');
        $cidades = $cidadeDAO->recuperarPorEstado($estado);
        $selectCidades = '<select name="cidade" id="cidade-select">';
        if(count($cidades)>1){
            foreach ($cidades as $row){
                $selectCidades.='<option value="'.$row->getId().'">'.  $row->getNome().'</option>';
            }
        }else{
            $selectCidades.='<option value="'.$cidades->getId().'">'.  $cidades->getNome().'</option>';
        }
        $selectCidades.='</select>'; 
        $data = array('success' => true,'cidades' => $selectCidades);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function getEstadosAction(){
        $estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $Array_estado = $estadoDAO->recuperarTodos(null, null);
        $dados_select = array();
        foreach ($Array_estado as $row){
            $dados_select[$row->getId()] = $row->getUf();
        }
        return $dados_select;
    }
    
    
    
    //formularios
    private function formCriarBairroAction(){//funcao que exibe o formulario e carrega os estados
        $dados_select = $this->getEstadosAction();
        $form = new form_criar_bairro();//1- primeiro eu instancio o formulario
        $form->get('uf')->setAttribute('options', $dados_select);
        return $form;
    }
    
    private function criarTabelaAction($bairrosList){
        $lista = new ViewModel(array('bairrosList'=>$bairrosList));
        $lista->setTemplate('application/bairro/partials/listar.phtml');
        return $lista;
    }
    
    private function criarBarraPaginacaoAction($paginacao){
        $view = new ViewModel(array('paginacao'=>$paginacao,'rota'=>'crud_bairro'));//na view $rota.'proximaPagina'
        $view->setTemplate('application/partials/paginacao.phtml');
        return $view;
    }
    
    private function criarBarraDeBuscaAction($rota,$estados,$filtro,$param){//passando os params para o application/src/form
        $busca = new form_busca(null,array(),$filtro,$param);//1- primeiro eu instancio o formulario
        $busca->get('filtro')->setAttribute('options',array('selecione'=>'selecione','id' => 'nome','cidade' => 'cidade'));
        $view = new ViewModel(array('rota' => $rota, 'busca' => $busca, 'listaEstados' => $estados));
        $view->setTemplate('application/bairro/partials/busca.phtml');
        return $view;
    }
    //formularios
}
