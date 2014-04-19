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
        $estadoDAO = new \Application\Model\estado;
        $Array_estado = $estadoDAO->getAll(null, null);
        $dados_select = array();
        foreach ($Array_estado as $row){
            $dados_select[$row->getId()] = $row->getUf();
        }
        $form = new form_criar_bairro();//1- primeiro eu instancio o formulario
        $form->get('uf')->setAttribute('options', $dados_select);
        $request = $this->getRequest();//2- pego a requisiçao
        if($request->isPost()){//3-verifico se é um post se for:
            $bairroFilter = new criar_bairro_filter();//4- instancio os filtros
            $params = $request->getPost()->toArray();//5- recupero os paramentros que vieram do post
            $form->setData($params);//6a- seto o formulario com os parametros que vieram do post
            $form->setInputFilter($bairroFilter->getInputFilter());//6b- e seto o formulario com o filtro que eu instanciei
            if($form->isValid()){
                echo 'ok';
            }
        }        
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate('layout/admin');
        $this->appendJavaScript('imovel.js');
        $view = new ViewModel(array('form'   =>  $form));
        return $view;
    }
    
    public function getCidadesAction(){        
        $uf = $this->getEvent()->getRouteMatch()->getParam('uf');
        $estadoDAO = new \Application\Model\estado;
        $estado = $estadoDAO->select($uf);
        $cidadeDAO = new \Application\Model\cidade;
        $cidades = $cidadeDAO->recuperarPorEstado($estado);
        $selectCidades = '<select id="cidade-select">';
        foreach ($cidades as $row){
            $selectCidades.='<option value="'.$row->getId().'">'.  utf8_encode($row->getNome()).'</option>';
        }
        $selectCidades.='</select>';   
        $data = array('success' => true,'cidades' => $selectCidades);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    
    
}
