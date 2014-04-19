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
class estado extends \Base\Model\AbstractModel {
    private $_paisDao;
    
    public function __construct() {
        $this->_paisDao = new PaisModel();
    }
    public function criarNovo($params = null){
      return new EstadoEntity($params);    
    }
    
    public function criarVarios($results){
        $lista_estados = array();
        foreach($results as $result){
            $dadosPais = $this->_paisDao->select($result['pais']);
            $paisObj = $this->_paisDao->criarNovo($dadosPais);
            $result['pais']=$paisObj;
            $lista_estados[] = $this->criarNovo($result);
        }
        if(count($lista_estados)>1){
            $response = $lista_estados;
        }else{
            $response = $lista_estados[0];
        }
        return $response;
    }
    
    public function insert($obj){
        
    }
    
    public function update($obj){
        
    }
    
    public function select($id){
        $adapter = $this->getAdapter();
        $sql = "select * from estado where(uf ='".$id."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return $this->criarVarios($results);
    }
    
    public function delete($obj){
        
    }
    
    public function save($obj){
        
    }
    
    public function getAll($de,$qtd){
        if($de == null and $qtd == null){
            $adapter = $this->getAdapter();
            $sql = 'select * from estado where(pais = 1)';
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            return $this->criarVarios($results);
        }
    }
}