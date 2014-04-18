<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author thiago
 * 
 */
namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Base\Session\BaseSession;

class BaseAbstractController extends AbstractActionController{
    protected $sessao;
    
    public function __construct() {
        $this->sessao = new BaseSession();//verificar se ha um jeito de tirar da inicialização
    }
}