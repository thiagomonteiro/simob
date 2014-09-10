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
use Application\Form\Imovel\passo2 as form_passo2;

class ImovelController extends \Base\Controller\BaseController{
    private $_ImovelDao;
    private $_EstadoDao;
    private $_CidadeDao;
    private $_BairroDao;
    private $_CategoriaImovelDao;
    private $_SubCategoriaImovelDao;
    private $_TipoComodosDao;
    private $_TipoTransacaoDao;
    private $_imovel_session;
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
               $params['tipoTransacao'] = $this->_TipoTransacaoDao->recuperar($params['tipoTransacao']);
               $params['subCategoria'] = $this->_SubCategoriaImovelDao->recuperar($params['subCategoria']);
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
        $view = new ViewModel(array('partialCadastro1'   =>  $form));
        return $view;
    }
    
    public function passo2Action(){
        $this->SessionHelper()->definirSessao('imovel');
        $dados_sessao = $this->SessionHelper()->recuperarObjeto('imovel');
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagem = $this->criarNotificacao($mensagem,'success');
        }
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $form = $this->getFormPasso2(); 
        $view = new ViewModel(array('partialCadastro2'   => $form ));
        return $view;
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
    
    public function getFormPasso2(){
        $form = new form_passo2();
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
}