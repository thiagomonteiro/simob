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
use Application\Form\login as form_login;
use Application\Filter\login as login_filter;
use Zend\Debug\Debug;
use Application\Model\Administrador as AdmModel;
use Zend\Session\Container;


class SiteController extends \Base\Controller\BaseController{
    public function __construct() {
        parent::__construct();
    }
    
    public function indexAction() {
        /*$proprietarioDao = \Base\Model\daoFactory::factory('Proprietario');
        $obj = $proprietarioDao->recuperar(10);        
        print_r($obj);
        for($i = 0; $i< 100; $i++){
            $proprietarioDao->salvar($obj);
        }*/
        $imovelDao = \Base\Model\daoFactory::factory('Imovel');
        $objs = $imovelDao->recuperarTodos();
        print_r($objs);
        $dados=array();
        $view = new ViewModel(array('dados' => $dados));
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate('/layout/layout');
        return $view;
    }
}
?>

