<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\bairro;
use Application\Model\cidade;
/**
 * Description of bairro
 *
 * @author thiago
 */
class Bairro extends \Base\Model\AbstractModel {
    private $_bairro;
    private $_cidadeDao;
    
    public function __construct() {
        $this->_bairroObj = new bairro();
        $this->_cidadeDao = new cidade;
    }
    
    
    public function criarNovo($params = null){
      return $this->_bairroObj->preencherPropriedades($params);    
    }
    
     public function save($obj){
        
    }
    
    protected function insert($obj){
        try {
            $adapter =  $this->getAdapter();
            $sql = "";
            $statement = $adapter -> query($sql);
            $results = $statement -> execute();
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
    
    protected function update($obj){
        
    }
    
    public function select($obj){
        
    }
    
    public function delete($obj){
        
    }
    
    public function getAll($de,$qtd){
        if($de == null and $qtd == null){
        try{
            $adapter = $this->getAdapter();
            $sql = 'select * from cidade where(estado = )';
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
        }  catch (Exception $e){
            return false;
        }
        }
    } 
}
