<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Pais as PaisEntity;

/**
 * Description of pais
 *
 * @author thiago
 */
class Pais extends \Base\Model\AbstractModel {
    
    public function __construct() {
        
    }
    
    public function criarNovo($params=null){
      return new PaisEntity($params);    
    }
    
   
    
    public function inserir($obj){
        
    }
    
    public function atualizar($obj){
        
    }
    
    public function recuperar($id){
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM pais WHERE(id='".$id."')";
        $statement = $adapter->query($sql);
        $results =  $statement->execute();
        $arrayPais = array();
        foreach ($results as $row){
            $arrayPais = $row;
        }
        return $arrayPais;
    }
    
    public function remover($obj){
        
    }
    
    public function recuperarTodos($de,$qtd){
           
    }
}
