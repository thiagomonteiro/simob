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


class SiteController extends \Base\Controller\BaseController{
    public function __construct() {
        parent::__construct();
    }
    
    public function indexAction() {
        parent::indexAction();
        $imovelDao = \Base\Model\daoFactory::factory('Imovel');
        $imoveis = $imovelDao->recuperarAnuncios();
        $this->setTemplate('/layout/layout');
        $this->appendJavaScript("simob/home.js");
        $view = new ViewModel(array('imoveis_list'=>$imoveis));
        return $view;
    }
}


