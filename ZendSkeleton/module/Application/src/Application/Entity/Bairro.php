<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of bairro
 *
 * @author thiago
 */
class bairro extends \Base\Entity\AbstractEntity {
    private $_id;
    private $_nome;
    private $_cidade;
    
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
    
    public function setCidade(\Application\Entity\Cidade $cidade){
        $this->_cidade = $cidade;
    }
    
    public function getCidade(){
        return $this->_cidade;
    }
}
