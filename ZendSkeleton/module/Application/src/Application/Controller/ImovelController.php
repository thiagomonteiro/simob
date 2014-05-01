<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\criarBairro as form_criar_bairro;
use Application\Filter\criarBairro as criar_bairro_filter;

/**
 * Description of ImovelController
 *
 * @author thiago
 */
class ImovelController extends \Base\Controller\BaseController {
    
   
    
    public function __construct() {
        parent::__construct();
    }
    
    public function indexAction() {
        parent::indexAction();
    }
    
 
    
    public function gerenciarBairroAction(){
        $BairroDao=\Base\Model\daoFactory::factory('Bairro');
        $result = $BairroDao->recuperarTodos(5,5);
        $paginacao = $this->paginador->paginarDados($result,5,5);
        print_r($paginacao);
        $mensagem = $this->flashMessenger()->getSuccessMessages();
        if(count($mensagem)){
                $this->layout()->mensagem = $this->criarNotificacao($mensagem,'success');
        }
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $view = new ViewModel(array('bairrosList' => $result,'paginacao' => $paginacao));
        return $view;
    }
    
    public function proximaPaginaAction(){
        //somente requisições ajax
    }
    
    public function paginaAnteriroAction(){
        //somente requisições ajax
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
                    $bairroDAO = \Base\Model\daoFactory::factory('Bairro');
                    $cidadeDAO = \Base\Model\daoFactory::factory('Cidade');
                    $cidadeOBJ = $cidadeDAO->recuperar($dados['cidade']);        
                    $bairroOBJ = $bairroDAO->criarNovo();
                    $bairroOBJ->setCidade($cidadeOBJ);
                    $bairroOBJ->setNome($dados['nome']);
                    $resposta = $bairroDAO->inserir($bairroOBJ);
                    $this->flashMessenger()->addSuccessMessage('bairro cadastrado com sucesso!');
                    $this->redirect()->toRoute('gerenciar_bairro');
                }else{  
                   //se der alguma errro 
                }
            }
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $view = new ViewModel(array('criar'   =>  $form));
        return $view;
    }
    
    
    public function formCriarBairroAction(){//funcao que exibe o formulario e carrega os estados
        $estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $Array_estado = $estadoDAO->recuperarTodos(null, null);
        $dados_select = array();
        foreach ($Array_estado as $row){
            $dados_select[$row->getId()] = $row->getUf();
        }
        $form = new form_criar_bairro();//1- primeiro eu instancio o formulario
        $form->get('uf')->setAttribute('options', $dados_select);
        return $form;
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
    
}
