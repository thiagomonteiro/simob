<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Application\Entity\Estado as EstadoEntity;
use Application\Model\Pais as PaisModel;
/**
 * Description of estado
 *
 * @author thiago
 */
class Estado extends \Base\Model\AbstractModel {
    private $_paisDao;
    
    public function __construct() {
        $this->_paisDao = new PaisModel();
    }
    public function criarNovo($params = null){
      return new EstadoEntity($params);    
    }
    
    public function criarVarios($results,$pais=null){
        $lista_estados = array();
        foreach($results as $result){
            if(is_null($pais)){
                $dadosPais = $this->_paisDao->recuperar($result['pais']);
                $paisObj = $this->_paisDao->criarNovo($dadosPais);
                $result['pais']=$paisObj;
            }else{
                $result['pais'] = $pais;
            }  
            $lista_estados[] = $this->criarNovo($result);
        }
        if(count($lista_estados)>1){
            $response = $lista_estados;
        }else{
            $response = $lista_estados[0];
        }
        return $response;
    }
    
    public function inserir($obj){
        
    }
    
    public function atualizar($obj){
        
    }
    
    public function recuperar($id){
        $adapter = $this->getAdapter();
        $sql = "select * from estado where(id ='".$id."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return $this->criarVarios($results);
    }
    
    public function recuperarPorUf($uf){       
        $adapter = $this->getAdapter();
        $sql = "select * from estado where(uf ='".$uf."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return $this->criarVarios($results);
    }
    
    public function remover($obj){
        
    }
    
   
    
    public function recuperarTodos($de,$qtd){
        if($de == null and $qtd == null){
            $adapter = $this->getAdapter();
            $sql = 'select * from estado where(pais = 1)';
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            return $this->criarVarios($results);
        }
    }
}