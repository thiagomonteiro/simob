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
class Bairro extends \Base\Entity\AbstractEntity {
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
        $this->_nome = utf8_encode($nome);
    }
    
    public function getNome(){
        return utf8_decode($this->_nome);
    }
    
    public function setCidade(\Application\Entity\Cidade $cidade){
        $this->_cidade = $cidade;
    }
    
    public function getCidade(){
        return $this->_cidade;
    }
}
