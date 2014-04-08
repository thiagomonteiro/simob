<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cidade
 *
 * @author thiago
 */

namespace Application\Entity;

class Cidade extends \Base\Entity\AbstractEntity {
    
    private $_id;
    private $_nome;
    private $_estado;
    
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
    
    public function setEstado(\Application\Entity\Estado $estado){
        $this->_estado = $estado;
    }
    
    public function getEstado(){
        return $this->_estado;
    }
}
