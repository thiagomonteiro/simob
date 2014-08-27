<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author thiago
 */
namespace Base\Session;

use Zend\Session\Container;

class BaseSession {
 
    private $user_session;    
    private $_Autenticado;
    
    public function __construct() {
       $this->user_session = new Container('user');
       if(isset($this->user_session->dados)){
           $this->_Autenticado = true;
       }
    }
    
    public function salvarSessaoUsuario($obj){
        $this->user_session->dados= serialize($obj);  
        $this->_Autenticado = true;
    }
    
    public function getSessaoUsuario(){
        return unserialize($this->user_session->dados);
    }
    
    public function limparSessaoUsuario(){
        $this->user_session->getManager()->getStorage()->clear('user');
        $this->_Autenticado = false;
    }
    
    public function isAutenticado(){
        return boolval($this->_Autenticado);
    }
   
     
}
