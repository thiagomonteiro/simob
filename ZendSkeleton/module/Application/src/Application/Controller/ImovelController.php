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
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Application\Form\Imovel\passo1 as form_passo1; 

class ImovelController extends \Base\Controller\BaseController{
    private $ImovelDao;
    private $EstadoDao;
    private $CidadeDao;
    private $BairroDao;
    private $TipoImovelDao;
    private $SubTipoImovelDao;
    private $TipoComodosDao;
    private $TipoTransacaoDao;
    
    private static $_qtd_por_pagina=5;
    /**
     * retorna uma list com os tipos de comodos {sala,quarto,suite,cozinha,garagem}
     */
    public function __construct() {
        parent::__construct();
        $this->ImovelDao=\Base\Model\daoFactory::factory('Imovel');
    }
    
   
    public function criarAction(){
        $this->setTemplate('layout/admin');
        $this->appendJavaScript('simob/imovel.js');
        $formCadastro= $this->getFormPasso1();
        $form= $this->getServiceLocator()->get('ViewRenderer')->render($formCadastro);
        $view = new ViewModel(array("partialCadastro1"   =>  $form));
        return $view;
    }
    
    public function getFormPasso1(){
        $form = new form_passo1();//1- primeiro eu instancio o formulario
        $view = new ViewModel(array('passo1'   =>  $form));
        $view->setTemplate('application/imovel/partials/passo1.phtml');
        return $view;
    }
}
