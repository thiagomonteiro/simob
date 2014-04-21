<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of bairro
 *
 * @author thiago
 */

namespace Application\Model;
use \Application\Entity\Bairro as BairroEntity;
use Application\Model\Cidade as CidadeModel;

class Bairro extends \Base\Model\AbstractModel {
    private $_bairroObj;
    private $_cidadeDao;
    
    public function __construct() {
        $this->_bairroObj = new BairroEntity();
        $this->_cidadeDao = new CidadeModel();
    }
    
    
    public function criarNovo($params = null){
      return $this->_bairroObj = new BairroEntity($params);
    }
    
    public function criarVarios($results,$cidade){
        
    }
    
    
    
    public function inserir($obj){
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO Bairro (nome,cidade)VALUES('".$obj->getNome()."','".$obj->getCidade()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
    }
    
    public function atualizar($obj){
        
    }
    
    public function recuperar($obj){
        
    }
    
    public function remover($obj){
        
    }
    
    public function recuperarTodos($de,$qtd){
        if($de == null and $qtd == null){
            
        }
    } 
}
