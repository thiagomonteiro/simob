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
use Application\Entity\TipoComodos as ComodoEntity;

class Comodo extends \Base\Model\AbstractModel {
    
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
    
    
    public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }
    
    public function inserir($obj){
        $adapter = $this->getAdapter();
        $sql = "INSERT INTO TipoComodos (descricao) VALUES ('".$obj->getDescricao()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
    }
    public function atualizar($obj){
        $adapter = $this->getAdapter();
        $sql =  "UPDATE TipoComodos SET descricao ='".$obj->getDescricao()."' WHERE id=".$obj->getId();
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
    }
    public function recuperar($obj){
        
    }
    
    public function remover($id){
      try{
        $adapter = $this->getAdapter();
        $sql = "DELETE FROM TipoComodos WHERE(id =".$id.")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return "ok";
         }catch(\Zend\Db\Adapter\Exception\RuntimeException $e){
           return "Não foi possível excluir, este Comodo faz referência a um imóvel ou proprietario";
       }
    }
    
    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null){  
         if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM TipoComodos LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $comodos_list = $this->criarVarios($results);
        return $comodos_list;
    }
    
    public function getAll(){
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM TipoComodos";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $comodos_list = $this->criarVarios($results);
        return $comodos_list;
    }
    
    public function recuperarPorParametro($de=null,$qtd=null,$param=null){ 
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd= self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM TipoComodos WHERE (descricao like '%".$param."%') LIMIT ".$de.", ".($qtd+1)."";      
        $statement = $adapter->query($sql);
        $results = $statement->execute();         
        $comodos_list = $this->criarVarios($results, null);
        return $comodos_list;
    }
}
