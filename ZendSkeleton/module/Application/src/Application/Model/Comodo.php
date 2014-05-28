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
namespace Application\Model;
use \Application\Entity\TipoComodo as ComodoEntity;

class Comodo extends \Base\Model\AbstractModel {
    
    private $_comodoDao;
    
    
    public function __construct() {
        
    }
    
    public function criarNovo($params = null){
      return  new ComodoEntity($params);
    }
    
    public function criarVarios($results){
        $lista_comodos = array();
        foreach ($results as $row){
            $lista_comodos[] = $this->criarNovo($row);
        }
        
        return $lista_comodos;
    }
    
    public function inserir($obj){
        
    }
    public function atualizar($obj){
        
    }
    public function recuperar($obj){
        
    }
    public function remover($obj){
        
    }
    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null){  
         if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd=5;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM TipoComodo LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $comodos_list = $this->criarVarios($results);
        return $comodos_list;
    }
}