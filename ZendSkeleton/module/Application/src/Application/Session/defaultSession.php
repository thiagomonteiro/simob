<?php

namespace Application\Session;
use Zend\Session\Container;

class defaultSession {
    private $_session;
    private $_hadados;
    
    public function __construct($name){
        $this->_session = new Container($name);
        if(isset($this->_session->$name)){
            $this->_hadados = true;
        }
    }
    
    public function salvarObjeto($name,$obj){
        $this->_session->$name = serialize($obj);  
        $this->_hadados = true;
    }
    
    public function recuperarObjeto($name){
        return unserialize($this->_session->$name);
    }
    
    public function limparObjeto($name){
        $this->_session->getManager()->getStorage()->clear($name);
        $this->_hadados = false;
    }
    
    
}
