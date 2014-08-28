<?php

namespace Application\Plugin;
use Zend\Session\Container;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SessionHelper extends AbstractPlugin {
    private $_session;
    private $_hadados;
    
    public function definirSessao($name){
        $this->_session = new Container($name);
    }
    
    public function salvarObjeto($name,$obj){
        $this->_session->$name = serialize($obj);  
        $this->_hadados = true;
    }
    
    public function recuperarObjeto($name){
        $this->_session = new Container($name);
        return unserialize($this->_session->$name);
    }
    
    public function limparObjeto($name){
        $this->_session->getManager()->getStorage()->clear($name);
        $this->_hadados = false;
    }
    
    
}
