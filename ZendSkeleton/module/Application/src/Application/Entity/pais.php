<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of pais
 *
 * @author thiago
 */
class Pais extends \Base\Entity\AbstractEntity {
    
    private $_id;
    private $_nome;
    private $_sigla;
    
   
    
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
    
    public function setSigla($sigla){
        $this->_sigla = $sigla;
    }
    
    public function getSigla(){
        return $this->_sigla;
    }

}
