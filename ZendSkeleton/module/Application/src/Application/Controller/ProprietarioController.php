<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Controller;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Imovel\passo1 as form_passo1; 

class ProprietarioController extends \Base\Controller\BaseController{
    private $ProprietarioDao;
   
    
    private static $_qtd_por_pagina=5;
    
    
    public function __construct() {
        parent::__construct();
        $this->ProprietarioDao=\Base\Model\daoFactory::factory('Proprietario');
    }
    
   
    public function indexAction() {
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('proprietario');
        $view = new ViewModel();
        return $view;
    }


    public function criarAction(){
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('proprietario');
        $view = new ViewModel(array());
        return $view;
    }
    
    }

