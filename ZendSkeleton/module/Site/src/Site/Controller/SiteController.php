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
            $image = $this->SimpleImage();
            echo'<img src="/fotos/picture.jpg">';
            $image->load('./public/fotos/picture.jpg'); 
            $image->resize(100,100);
            $image->save('./public/fotos/picture.jpg'); 
            $dados_uf = $this->Localidades()->getEstados();
            //print_r($dados_uf);
            $view = new ViewModel();
            $event = $this->getEvent();
            $event->getViewModel()->setTemplate('layout/layout');
            return $view;
    }
}
?>

