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

class BaseController extends AbstractActionController{
    protected $sessao;
  
    
    public function __construct() {
        $this->sessao = new BaseSession();//verificar se ha um jeito de tirar da inicialização        
    }
    
    public function appendJavaScript($js){
        //adicionando scripts pelo controller
        $script = $this->getServiceLocator()->get('viewhelpermanager')
                ->get('inlineScript');
        // No need to add beginning or ending <script> tags, as they
        // will be automatically inserted by the appendScript method.
        $script->appendFile(
                '/js/'.$js,
                'text/javascript',
                array('noescape' => true)); // Disable CDATA comments
    }
    
    public function criarNotificacao($mensagem,$tipo){
        //implementar if para array
        return '<div class = "response-error" tipo ="'.$tipo.'">'.$mensagem.'</div>';
    }
}