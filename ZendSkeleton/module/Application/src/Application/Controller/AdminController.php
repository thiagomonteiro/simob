<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Controller;

/**
 * Description of AdminController
 *
 * @author thiago
 */



use Zend\View\Model\ViewModel;
use Application\Form\login as form_login;
use Application\Filter\login as login_filter;
use Zend\Debug\Debug;
use Application\Model\Administrador as AdmModel;
use Application\Entity\Administrador as AdmEntity;
use Zend\Session\Container;


class AdminController extends \Base\Controller\BaseAbstractController{
    
    public function indexAction() {
        //$sessao = $this->sessao->getDados();
        $view = new ViewModel();
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate('layout/admin');
        return $view; 
    }
    
    public function loginAction(){       
        $form = new form_login();//1- primeiro eu instancio o formulario
        $request = $this->getRequest();//2- pego a requisiçao
        if($request->isPost()){//3-verifico se é um post se for:
            $loginFilter = new login_filter();//4- instancio os filtros
            $params = $request->getPost()->toArray();//5- recupero os paramentros que vieram do post
            $usuarioDto = new AdmEntity($params);
            $form->setData($params);//6a- seto o formulario com os parametros que vieram do post
            $form->setInputFilter($loginFilter->getInputFilter());//6b- e seto o formulario com o filtro que eu instanciei
            if($form->isValid()){
                $response = $this->validarLoginAction($usuarioDto);
                if($response['success']){
                  $this->sessao->salvarDados($usuarioDto);
                  $this->redirect()->toRoute('home_admin');
                }
                else{
                   echo $response['message'];
                }
               
            }
        }
        $view = new ViewModel(array('form'=>$form));
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate('layout/login');
        return $view;    
    }
    
    
     public function validarLoginAction($usuarioDto){
        $usuarioDao = new AdmModel();
        $result = $usuarioDao->selectLogin($usuarioDto);
        if(is_array($result)){
            if(count($result)>0){
                return array('success' => true);
            }else{
                return array('success' => false, 'message' => 'nome de usuario ou senha invalidos');
            }
        }else{
            return array('success'=>false, 'message' => 'falha ao comunicar com o banco de dados');
        }

    }

    
  
}
