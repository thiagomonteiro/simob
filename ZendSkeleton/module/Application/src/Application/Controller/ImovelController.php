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
use Application\Filter\Imovel\passo1 as filtro_passo1;
use Application\Filter\Imovel\passo2 as filtro_passo2;
use Application\Filter\Imovel\passo3 as filtro_passo3;
use Application\Form\Imovel\passo2 as form_passo2;
use Application\Form\Proprietario\busca as form_busca;
use Application\Form\Imovel\passo3 as form_passo3;
use Application\Form\Imovel\alterarPasso1 as form_alterar_passo1;
use Application\Form\Imovel\alterarPasso2 as form_alterar_passo2;
use ArrayObject;

class ImovelController extends \Base\Controller\BaseController{
    private $_ImovelDao;
    private $_EstadoDao;
    private $_CidadeDao;
    private $_BairroDao;
    private $_CategoriaImovelDao;
    private $_SubCategoriaImovelDao;
    private $_TipoComodosDao;
    private $_TipoTransacaoDao;
    private $_ProprietarioDao;
    private $_ImovelComodoDao;
    private $_imovel_session;
    private $_MidiaDao;
    private $_ImovelStatusDao;
    /**
     * retorna uma list com os tipos de comodos {sala,quarto,suite,cozinha,garagem}
     */
    public function __construct() {
        parent::__construct();
        $this->_ImovelDao = \Base\Model\daoFactory::factory('Imovel');
        $this->_BairroDao = \Base\Model\daoFactory::factory('Bairro');
        $this->_CidadeDao = \Base\Model\daoFactory::factory('Cidade');
        $this->_EstadoDao = \Base\Model\daoFactory::factory('Estado');
        $this->_TipoTransacaoDao = \Base\Model\daoFactory::factory('TipoTransacao');
        $this->_CategoriaImovelDao = \Base\Model\daoFactory::factory('CategoriaImovel');
        $this->_SubCategoriaImovelDao = \Base\Model\daoFactory::factory('SubCategoriaImovel');
        $this->_TipoComodosDao = \Base\Model\daoFactory::factory('Comodo');
        $this->_ProprietarioDao = \Base\Model\daoFactory::factory('Proprietario');
        $this->_ImovelComodoDao = \Base\Model\daoFactory::factory('ImovelComodo');
        $this->_MidiaDao = \Base\Model\daoFactory::factory('Midia');
        $this->_ImovelStatusDao = \Base\Model\daoFactory::factory('ImovelStatus');
    }
    
    public function indexAction() {
        $this->setTemplate('layout/admin');
        $result = $this->_ImovelDao->recuperarTodos();
        $paginacao = $this->paginador->paginarDados($result,null,self::$_qtd_por_pagina);        
        $partialListarImoveis = $this->criarTabelaAction($result);
        $partialBarraPaginacao = $this->criarBarraPaginacaoAction($paginacao);
        $view = new ViewModel(array('haDados' => empty($result)? false:true));
        $this->appendJavaScript('simob/imovelindex.js');
        $view->addChild($partialListarImoveis ,'partialListarImoveis');
        $view->addChild($partialBarraPaginacao ,'paginacao');
        return $view;
    }
    
    public function proximaPaginaAction(){
        //somente requisições ajax 
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
            $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');           
            $imoveisList = $this->_ImovelDao->recuperarTodos($pagina,self::$_qtd_por_pagina);
            $paginacao = $this->paginador->paginarDados($imoveisList,$pagina,self::$_qtd_por_pagina);
            $viewModelListar= $this->criarTabelaAction($imoveisList);
            $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
            $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
            $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
            $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
            return $this->getResponse()->setContent(Json_encode($data));
        }
    }
    
    public function paginaAnteriorAction(){
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
            $pagina = $this->getEvent()->getRouteMatch()->getParam('pagina');
            $imoveisList = $this->_ImovelDao->recuperarTodos($pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
            $paginacao = $this->paginador->paginarDados($imoveisList,$pagina - (self::$_qtd_por_pagina - 1),self::$_qtd_por_pagina);
            $viewModelListar= $this->criarTabelaAction($imoveisList);
            $html= $this->getServiceLocator()->get('ViewRenderer')->render($viewModelListar);
            $viewModelPaginar= $this->criarBarraPaginacaoAction($paginacao);
            $barraPaginacao = $this->getServiceLocator()->get('ViewRenderer')->render($viewModelPaginar);
            $data = array('success' => true,'html' => $html, 'barrapaginacao' => $barraPaginacao);
            return $this->getResponse()->setContent(Json_encode($data));
        }
    }
    
     private function criarTabelaAction($imoveisList){
        $lista = new ViewModel(array('imoveisList'=>$imoveisList));
        $lista->setTemplate('application/imovel/partials/listar.phtml');
        return $lista;
    }
    
    private function criarBarraPaginacaoAction($paginacao){
        $view = new ViewModel(array('paginacao'=>$paginacao,'rota'=>'crud_imovel'));//na view $rota.'proximaPagina'
        $view->setTemplate('application/partials/paginacao.phtml');
        return $view;
    }
    
    public function ativarAction(){
       $id = $this->getEvent()->getRouteMatch()->getParam('id');
       $aux = $this->_ImovelDao->ativarInativar($id, \Application\Entity\TipoStatus::ATIVO);
    }
    
    public function inativarAction(){
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $aux = $this->_ImovelDao->ativarInativar($id, \Application\Entity\TipoStatus::INATIVO);
    }
    
    public function deletarAction(){
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $imovel = $this->_ImovelDao->recuperar($id);        
        $midias = $this->_MidiaDao->recuperarPorImovel($imovel[0]);
        $this->_MidiaDao->removerVarias($midias);
        $this->_ImovelDao->remover($id);
    }
    
    public function alterarPasso1Action(){
        $request = $this->getRequest();
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $imovel = $this->_ImovelDao->recuperar($id);
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->formAlterarPasso1Action($params,$imovel[0]); 
            $Filter = new filtro_passo1();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){                                             
               $params['bairro'] = $this->_BairroDao->recuperar($params['bairro']);
               $params['tipoTransacao'] = $this->_TipoTransacaoDao->recuperar($params['tipoTransacao']);
               $params['subCategoria'] = $this->_SubCategoriaImovelDao->recuperar($params['subCategoria']);
               $imovelStatus = $this->_ImovelStatusDao->criarNovo();
               $imovelStatus->setStatus(\Application\Entity\TipoStatus::ATIVO);
               $params['imovelStatus'] = $imovelStatus;
               $imovelNew = $this->_ImovelDao->criarNovo($params);
               $imovelNew->setId($id);
               $imovelNew->setPersistido(true);
               $this->SessionHelper()->definirSessao('imovel');
               $this->SessionHelper()->salvarObjeto('imovel', $imovelNew);
               $id =$this->_ImovelDao->atualizarPasso1($imovelNew);
               $this->flashMessenger()->addSuccessMessage('Dados atualizados com sucesso!');
               $this->redirect()->toRoute('crud_imovel/alterarPasso2');
            }else{  
            }
        }else{
            $form = $this->formAlterarPasso1Action(array(),$imovel[0]); 
        }
         $this->setTemplate('layout/admin');
         $this->appendJavaScript('simob/imovel.js');
         $this->appendJavaScript('libs/jquery.maskMoney.min.js');
         $view = new ViewModel(array('form'   =>  $form, 'id' => $id));
         return $view;
    }
    
    public function formAlterarPasso1Action($dadosPost=array(),$imovel){
        //setando uf
        $dados_uf = $this->Localidades()->getEstados();        
        unset($dados_uf[0]);
        $uf =  $imovel->getBairro()->getCidade()->getEstado(); 
        $dados_uf[$uf->getId()]["selected"]="selected";
        //uf
        //setando cidade
        $cidade = $imovel->getBairro()->getCidade();
        $dados_cidade = $this->Localidades()->getCidades($uf->getUf());        
        $dados_cidade[$cidade->getId()]["selected"]="selected";
        //cidade
        //setando bairro
        $bairro = $imovel->getBairro();
        $dados_bairro = $this->Localidades()->getBairros($cidade);
        $dados_bairro[$bairro->getId()]["selected"]="selected";
        //bairro
        $form = new form_alterar_passo1();//1- primeiro eu instancio o formulario
        $form->get('uf')->setAttribute('options', $dados_uf);
        $form->get('cidade')->setAttribute('options', $dados_cidade); 
        $form->get('bairro')->setAttribute('options', $dados_bairro);
        $form->get('rua')->setAttribute('value', $imovel->getRua());        
        $form->get('numero')->setAttribute('value', $imovel->getNumero());
        $form->get('descricao')->setAttribute('value', $imovel->getDescricao());
        $form->get('areaTotal')->setAttribute('value', $imovel->getAreaTotal());
        $form->get('areaConstruida')->setAttribute('value', $imovel->getAreaConstruida());
        $form->get('valorIptu')->setAttribute('value', $imovel->getValorIptu());
        
        $operacoes = $this->_TipoTransacaoDao->recuperarTodos();
        $dados_select_operacao = $this->SelectHelper()->getArrayDataAlterar($imovel->getTipoTransacao()->getId(),$operacoes); 
        $form->get('tipoTransacao')->setAttribute('options', $dados_select_operacao);

        $form->get('valorTransacao')->setAttribute('value', $imovel->getValorTransacao());
        
        $categorias = $this->_CategoriaImovelDao->recuperarTodos();
        $dados_select_categoria = $this->SelectHelper()->getArrayDataAlterar($imovel->getSubCategoria()->getCategoria()->getId(),$categorias);
        $form->get('categoria')->setAttribute('options', $dados_select_categoria);
        
        $subCategorias = $this->_SubCategoriaImovelDao->recuperarTodosPorCategoria($imovel->getSubCategoria()->getCategoria()->getId());
        $dados_select_subCategoria = $this->SelectHelper()->getArrayDataAlterar($imovel->getSubCategoria()->getId(),$subCategorias);               
        $form->get('subCategoria')->setAttribute('options', $dados_select_subCategoria);
        return $form;
    }
    
    public function alterarPasso2Action(){
        $request = $this->getRequest();
        $this->SessionHelper()->definirSessao('imovel');
        $imovel_sessao = $this->SessionHelper()->recuperarObjeto('imovel');        
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagemTopo = $this->criarNotificacao($mensagem,'success','center');
        }
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->getFormPasso2($params,$imovel_sessao);//passo o objeto imovel para o formulario para que seja verificado se ele e do tipo terreno caso seja nao exibo comodos. 
            $Filter = new filtro_passo2();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){
                $proprietarioObj = $this->_ProprietarioDao->recuperar($params['idProprietario']);
                $imovel_sessao->setProprietario($proprietarioObj);
                $aux = $this->_ImovelDao->atualizarPasso2($imovel_sessao);
                $this->SessionHelper()->definirSessao('imovel');//redefinindo a sessao apos salvar o id do imovel
                $this->SessionHelper()->salvarObjeto('imovel', $imovel_sessao);
                $this->flashMessenger()->addSuccessMessage('Passo 2 concluído com sucesso! complete o cadastro');
                $this->redirect()->toRoute('crud_imovel/passo3');
            }else{/*se nao for valido*/}
        }else{
            $form = $this->formAlterarPasso2(array(),$imovel_sessao); 
        }
        $partialBuscaProprietario = $this->GetViewBarraDeBuscaProprietario('crud_proprietario/buscar',null);
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $this->appendJavaScript('libs/jquery.maskMoney.min.js');
        $view = new ViewModel(array('form'   =>  $form, 'id' => $imovel_sessao->getId()));
        $view->addChild($partialBuscaProprietario , 'buscaProprietario');
        return $view;
    }
    
    public function formAlterarPasso2($dados_post = array(), $imovel){       
        $form = new form_alterar_passo2(null, array(), array(),$imovel);
        return $form;
    }
    
    public function alterarPasso3Action(){
        
    }
    
    public function passo1Action(){
        $request = $this->getRequest();
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->getFormPasso1($params); 
            $Filter = new filtro_passo1();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){
               $params['bairro'] = $this->_BairroDao->recuperar($params['bairro']);
               $params['tipoTransacao'] = $this->_TipoTransacaoDao->recuperar($params['tipoTransacao']);
               $params['subCategoria'] = $this->_SubCategoriaImovelDao->recuperar($params['subCategoria']);
               $imovelStatus = $this->_ImovelStatusDao->criarNovo();
               $imovelStatus->setStatus(\Application\Entity\TipoStatus::ATIVO);
               $params['imovelStatus'] = $imovelStatus;
               $imovelObj = $this->_ImovelDao->criarNovo($params);
               $this->SessionHelper()->definirSessao('imovel');
               $this->SessionHelper()->salvarObjeto('imovel', $imovelObj);
               $this->flashMessenger()->addSuccessMessage('Passo 1 concluído com sucesso! complete o cadastro');
               $this->redirect()->toRoute('crud_imovel/passo2');
            }else{  
            }
        }else{
            $form = $this->getFormPasso1(); 
        }
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $this->appendJavaScript('libs/jquery.maskMoney.min.js');
        $view = new ViewModel(array('partialCadastro1'   =>  $form));
        return $view;
    }
    
    public function passo2Action(){
        $request = $this->getRequest();
        $this->SessionHelper()->definirSessao('imovel');
        $imovel_sessao = $this->SessionHelper()->recuperarObjeto('imovel');
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagemTopo = $this->criarNotificacao($mensagem,'success','center');
        }
        if($request->isPost()){
            $params = $request->getPost()->toArray();            
            $form = $this->getFormPasso2($params,$imovel_sessao);//passo o objeto imovel para o formulario para que seja verificado se ele e do tipo terreno caso seja nao exibo comodos. 
            $Filter = new filtro_passo2();
            $form->setData($params);
            $form->setInputFilter($Filter->getInputFilter());
            if($form->isValid()){
                $proprietarioObj = $this->_ProprietarioDao->recuperar($params['idProprietario']);
                $imovel_sessao->setProprietario($proprietarioObj);
                $status = $this->_ImovelStatusDao->salvar($imovel_sessao);//salvar os status do imovel passando o objeto imovel(possui imovelstatus encapsulado) como paramentro
                $imovel_sessao->setImovelStatus($status);
                $id = $this->_ImovelDao->salvar($imovel_sessao);
                $imovel_sessao->setId($id->insert_id);//apos cadastrar o imovel insiro o id retornado da função salvar. em seguida posso salvar os comodos
                $this->SessionHelper()->definirSessao('imovel');//redefinindo a sessao apos salvar o id do imovel
                $this->SessionHelper()->salvarObjeto('imovel', $imovel_sessao);
                $listComodos = new ArrayObject();
                $this->setCapaDefault();
                $this->flashMessenger()->addSuccessMessage('Passo 2 concluído com sucesso! complete o cadastro');
                $this->redirect()->toRoute('crud_imovel/passo3');
            }else{  
            }
        }else{
            $form = $this->getFormPasso2(array(),$imovel_sessao); 
        }
        $partialBuscaProprietario = $this->GetViewBarraDeBuscaProprietario('crud_proprietario/buscar',null);
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $this->appendJavaScript('libs/jquery.maskMoney.min.js');
        $view = new ViewModel(array('partialCadastro2'   => $form ));
        $view->addChild($partialBuscaProprietario , 'buscaProprietario');
        return $view;
    }
    
    public function passo3Action(){
      $request = $this->getRequest();
      $this->SessionHelper()->definirSessao('imovel');
      $imovel_sessao = $this->SessionHelper()->recuperarObjeto('imovel');      
      $mensagem = $this->flashMessenger()->getSuccessMessages();
      if(count($mensagem)){
        $this->layout()->mensagemTopo = $this->criarNotificacao($mensagem,'success','center');
      }
      $form = $this->getFormPasso3();
      $midiasSalvas = array();
      if($request->isPost()){
          $postData = array_merge_recursive(
                  $this->getRequest()->getPost()->toArray(),
                  $this->getRequest()->getFiles()->toArray()
          );
          $form->setData($postData);
          $Filter = new filtro_passo3();
          $form->setInputFilter($Filter->getInputFilter());
          if($form->isValid()){              
              $data = $form->getData();
              $response = $this->saveImage($data['uploadfile']);
              return $response;
          }else{    
               $data = array('success' => false,'mensagem' => "limite de 16 fotos");
               $response = $this->getResponse()->setContent(Json_encode($data));
               return $response;
          }
      }else{//acionado quando o usuário der um refresh na pagina, impede que as imagens sumam
       $midiasSalvas = $this->_MidiaDao->recuperarTodos(null,null,null,$imovel_sessao->getId());          
      }
      $this->setTemplate('layout/admin');
      $this->appendJavaScript('simob/galeria.js');
      $this->appendJavascript('libs/jquery.form.js');
      $view = new ViewModel(array('partialCadastro3'   => $form , 'midiasSalvas' => $midiasSalvas));
      return $view;
    }
    
    private function saveImage($fotos){
       $request = $this->getRequest();
       if($request->isXmlHttpRequest()){
            if(isset($fotos))
            {            
                date_default_timezone_set("Brazil/East");
                $allowedExts = array(".gif", ".jpeg", ".jpg", ".png", ".bmp");
                $dir = $_SERVER['DOCUMENT_ROOT'].'/fotos/';
                $miniaturas='';
                foreach ($fotos as $row){
                   $name = $row['name'];
                   $tmp_name = $row['tmp_name'];
                   $ext = strtolower(substr($name, -4));
                   if(in_array($ext,$allowedExts))
                   {
                       $new_name = date("Y.m.d-H.i.s") ."-".uniqid().$ext; //gera o nome baseado na date() e na função uniqid
                       $aux = move_uploaded_file($row['tmp_name'],$dir.$new_name);
                       $image = $this->SimpleImage();
                       $image->load($dir.$new_name); 
                       $image->resize(600,600);
                       $image->save($dir.$new_name); 
                       $midiaObj = $this->_MidiaDao->criarNovo();
                       $midiaObj->setTipo(1);
                       $midiaObj->setCapa(false);
                       $midiaObj->setNome(str_replace($allowedExts,"", $name));//removendo extensões do nome
                       //$midiaObj->setUrl($dir.$new_name);
                       $midiaObj->setUrl("/fotos/".$new_name);
                       $imovel_sessao = $this->SessionHelper()->recuperarObjeto('imovel');
                       $midiaObj->setImovel($imovel_sessao);
                       $data = $this->_MidiaDao->salvar($midiaObj);
                       $midiaObj->setId($data->insert_id);
                   }
                }
                $data = array('success' => true);
                return $this->getResponse()->setContent(Json_encode($data));
            }
       }
    }
    
    public function removerImagemAction(){
       $request = $this->getRequest();
       if($request->isXmlHttpRequest()){
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
            $response = $this->_MidiaDao->remover($id);
            if($response == "ok"){
                $data = array('success' => true,'menssagem'=>'Imagem removida com sucesso');
            }else{
                $data = array('success' => false,'menssagem' => $response);
            }
            return $this->getResponse()->setContent(Json_encode($data));
       }
    }
    
    public function alterarImagemAction(){
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
            $nome = $this->getEvent()->getRouteMatch()->getParam('nome');
            $obj = $this->_MidiaDao->recuperar($id);
            $obj->setNome(str_replace("-", " ", $nome));
            $obj->setPersistido(true);
            try{
                $response = $this->_MidiaDao->salvar($obj);
                $data = array("success" => true, "mensagem" => "nome atualizado");
            } catch (\Zend\Db\Adapter\Exception\RuntimeException $e) {
                $data = array("success" => false, "mensagem" => "Falha ao atualizar");
            }
            return $this->getResponse()->setContent(json_encode($data));
        }
    }
    
    public function selecionarCapaAction(){
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
            try{
                $id = $this->getEvent()->getRouteMatch()->getParam('id');
                $this->_MidiaDao->salvarCapa($id);
                 $data = array('success' => true,'menssagem'=>'Capa selecionada');
            }  catch (\Zend\Db\Adapter\Exception\RuntimeException $e){
                 $data = array('success' => false,'menssagem' => "falha ao selecionar capa");
            }       
            return $this->getResponse()->setContent(Json_encode($data));
        }
    }
    
    /*
     * seta uma imagem antes do usuario selecionar as imagens isso impede que o 
     * usuario deixe o album vazio atrapalhando o função sql que recupera os imoveis
     * para exibir no front end
     */
    private function setCapaDefault(){
        $midiaObj = $this->_MidiaDao->criarNovo();
        $midiaObj->setTipo(0);
        $midiaObj->setCapa(true);
        $midiaObj->setNome("capa_default");
        $midiaObj->setUrl("/img/no_image.jpg");
        $imovel_sessao = $this->SessionHelper()->recuperarObjeto('imovel');
        $midiaObj->setImovel($imovel_sessao);
        $data = $this->_MidiaDao->salvar($midiaObj);
    }

        public function getFormPasso1($dadosPost=array()){
        $operacoes = $this->_TipoTransacaoDao->recuperarTodos();
        $categorias = $this->_CategoriaImovelDao->recuperarTodos();
        $dados_select_operacao = $this->SelectHelper()->getArrayData('selecione uma operação',$operacoes); 
        $dados_select_categoria = $this->SelectHelper()->getArrayData('selecione uma categoria',$categorias);
        if(empty($dadosPost)){
            $dados_uf = $this->Localidades()->getEstados();
            $form = new form_passo1();
            $form->get('uf')->setAttribute('options', $dados_uf);
            $form->get('tipoTransacao')->setAttribute('options', $dados_select_operacao);
            $form->get('categoria')->setAttribute('options', $dados_select_categoria);
            $optionsCidade = array(array( 'label' => 'Selecione um Estado','selected' => 'selected', 'disabled' => 'disabled'));
            $optionsBairro = array(array( 'label' => 'Selecione uma Cidade','selected' => 'selected', 'disabled' => 'disabled'));
            $optionsSubCategoria = array(array('label' => 'Selecione uma Categoria','selected' => 'selected', 'disabled' => 'disabled'));
            $form->get('cidade')->setAttribute('options', $optionsCidade);           
            $form->get('bairro')->setAttribute('options', $optionsBairro);
            $form->get('subCategoria')->setAttribute('options', $optionsSubCategoria);
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
            }else{
                $optionsCidade = array(array( 'label' => 'Selecione um Estado','selected' => 'selected', 'disabled' => 'disabled'));
                $optionsBairro = array(array( 'label' => 'Selecione uma Cidade','selected' => 'selected', 'disabled' => 'disabled'));
                $form->get('cidade')->setAttribute('options', $optionsCidade);           
                $form->get('bairro')->setAttribute('options', $optionsBairro);
            }
            $form->get('tipoTransacao')->setAttribute('options', $dados_select_operacao);
            if(empty($dadosPost['tipoTransacao']) != true){
               $form->get('tipoTransacao')->setAttribute('selected',$dadosPost['tipoTransacao']); 
            }
            $form->get('categoria')->setAttribute('options', $dados_select_categoria);
            if(empty($dadosPost['categoria']) != true){
               $form->get('categoria')->setAttribute('selected',$dadosPost['categoria']); 
               $subCategorias = $this->_SubCategoriaImovelDao->recuperarTodosPorCategoria($dadosPost['categoria']);
               $dados_select_subCategoria = $this->SelectHelper()->getArrayData('selecione uma sub categoria',$subCategorias);               
               $form->get('subCategoria')->setAttribute('options', $dados_select_subCategoria);
               if(empty($dadosPost['subCategoria']) != true){
                   $form->get('subCategoria')->setAttribute('selected',$dadosPost['subCategoria']);
               }
            }
        }
        return $form;
    }
    
    public function getFormPasso2($dados_post = array(), $imovel){       
        $form = new form_passo2(null, array(), array(),$imovel);
        return $form;
    }
    
    public function getFormPasso3($dados_post = array()){
        $form = new form_passo3(null, array());
        return $form;
    }
    
    public function getSubCategoriasAction(){
        $request = $this->getRequest();
        if($request->isGet()){
            $idCategoria = $this->getEvent()->getRouteMatch()->getParam('categoria');
            $subCategorias = $this->_SubCategoriaImovelDao->recuperarTodosPorCategoria($idCategoria);
            $selectList = $this->SelectHelper()->montarSelect($subCategorias,'subCategoria','sub-categoria-select','selecione uma subcategoria','id','descricao');
            $data = array('success' => true,'select' => $selectList);
            return $this->getResponse()->setContent(Json_encode($data)); 
        }
        
    }
    
     private function GetViewBarraDeBuscaProprietario($rota,$param=null){//passando os params para o application/src/form
        $busca = new form_busca(null,array(),$param);//1- primeiro eu instancio o formulario
        $busca->get('filtro')->setAttribute('options',array('selecione'=>'selecione','nome' => 'nome','cpf' => 'cpf'));
        $view = new ViewModel(array('rota' => $rota, 'busca' => $busca));
        $view->setTemplate('application/proprietario/partials/busca.phtml');
        return $view;
    } 
}