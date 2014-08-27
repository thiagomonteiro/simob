<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comodo
 *
 * @author thiago
 */
namespace Application\Entity;

class TipoComodos extends \Base\Entity\AbstractEntity{
    //put your code here
    private $_id;
    private $_descricao;
    
    public function setId($id){
        $this->_id = $id;
    }
    
    public function getId(){
        return $this->_id;
    }
    
    public function setDescricao($descricao){
        $this->_descricao = utf8_encode($descricao);
    }
    
    public function getDescricao(){
        return utf8_decode($this->_descricao);
    }
    
}
