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
use Base\Paginador\Paginador;

class BaseController extends AbstractActionController{
    protected $sessao;
    protected $paginador;
    protected static $_qtd_por_pagina=5;

    public function __construct() {
        $this->sessao = new BaseSession();//verificar se ha um jeito de tirar da inicialização        
        $this->paginador = new Paginador();
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
    
    public function appendCss($css){
        $script = $this->getServiceLocator()->get('viewhelpermanager')
                ->get('headLink');
        $script->appendStylesheet(
                '/css/'.$css,
                'screen',
                array('noescape' => true));
    }
    
    public function criarNotificacao($mensagem,$tipo,$posicao){
        //implementar if para array
        
        if(is_array($mensagem)){
            $response = '<div class = "response-notify" tipo ="'.$tipo.'" posicao="'.$posicao.'">'.implode("",$mensagem).'</div>';
        }else{
            $response = '<div class = "response-notify" tipo ="'.$tipo.'" posicao="'.$posicao.'">'.$mensagem.'</div>';
        }
        return $response;
    }
    
    public function getPartial($partial, array $dados){
        $partial = new ViewModel($dados);
        $partial->setTemplate($partial);
        return $partial;
    }
    
    public function setTemplate($template){
        $event = $this->getEvent();
        $event->getViewModel()->setTemplate($template);
    }
}