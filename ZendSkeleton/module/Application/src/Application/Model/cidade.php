<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Application\Entity\Cidade as CidadeEntity;
use Application\Model\estado as EstadoModel;
/**
 * Description of cidade
 *
 * @author thiago
 */
class cidade extends \Base\Model\AbstractModel{
    
    private $_estadoDAO;
    
    public function __construct() {
        $this->_estadoDAO = new EstadoModel();
    }
    
    public function criarNovo($params = null){
      return new CidadeEntity($params);    
    }
    
    public function criarVarios($results , $estadoObj){
        $lista_cidades = array();
        foreach($results as $result){
            $result['estado']=$estadoObj;
            $lista_cidades[] = $this->criarNovo($result);
        }
        if(count($lista_cidades)>1){
            $response = $lista_cidades;
        }else{
            $response = $lista_cidades[0];
        }
        return $response;
    }
    
     public function save($obj){
        //implements insert and update here;
    }
    
    protected function insert($obj){
        
    }
    
    protected function update($obj){
        
    }
    
    public function select($obj){
        
    }
    
    public function delete($obj){
        
    }
    
    public function getAll($de,$qtd){
        
    } 
    
    public function recuperarPorEstado(\Application\Entity\Estado $estado){
        try{
            $adapter = $this->getAdapter();
            $sql = 'select * from cidade where(estado ='.$estado->getId().')';
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            return $this->criarVarios($results,$estado);
        }catch (Exception $e){
            return false;
        }
    }
}
