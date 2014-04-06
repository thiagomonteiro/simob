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
    public function __construct() {
       $this->user_session = new Container('user');
    }
    
    public function salvarDados($obj){
        $this->user_session->dados= serialize($obj);    
    }
    
    public function getDados(){
        return unserialize($this->user_session->dados);
    }
   
     
}
