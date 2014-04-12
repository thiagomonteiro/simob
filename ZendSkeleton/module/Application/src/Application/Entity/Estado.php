<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;
use Application\Entity\Pais;

/**
 * Description of estado
 *
 * @author thiago
 */
class Estado extends \Base\Entity\AbstractEntity {
    //put your code here
    
    private $_id;
    private $_nome;
    private $_uf;
    private $_pais;
    
    
    
    public function setId($id){
        $this->_id = $id;
    }
    
    public function getId(){
        return $this->_id;
    }
    
    public function setNome($nome){
        $this->_nome = $nome;
    }
    
    public function getNome(){
        return $this->_nome;
    }
    
    public function setUf($uf){
        $this->_uf = $uf;
    }
    
    public function getUf(){
        return $this->_uf;
    }
    
    public function setPais(\Application\Entity\Pais $pais){
        $this->_pais = $pais;
    }
    
    public function getPais(){
        return  $this->_pais;
    }
    
}
