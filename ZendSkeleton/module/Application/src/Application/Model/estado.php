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
    
    public function criarNovo($params = null){
      return new EstadoEntity($params);    
    }
    
    public function insert($obj){
        
    }
    
    public function update($obj){
        
    }
    
    public function select($obj){
        
    }
    
    public function delete($obj){
        
    }
    
    public function getAll($de,$qtd){
        if($de == null and $qtd == null){
            $adapter = $this->getAdapter();
            $sql = 'select * from estado where(pais = 1)';
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            $lista_estados = array();
            
            foreach($results as $result){
                $paisDao =  new PaisModel();
                $dadosPais = $paisDao->select($result['pais']);
                $paisObj = $paisDao->criarNovo($dadosPais);
                $result['pais']=$paisObj;
                $lista_estados[] = new EstadoEntity($result);
            }
            return $lista_estados;
        }
    }
}
