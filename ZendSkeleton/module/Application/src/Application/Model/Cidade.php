<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Application\Entity\Cidade as CidadeEntity;
use Application\Model\Estado as EstadoModel;
/**
 * Description of cidade
 *
 * @author thiago
 */
class Cidade extends \Base\Model\AbstractModel{
    
    private $_estadoDAO;
    
    public function __construct() {
        $this->_estadoDAO = new EstadoModel();
    }
    
    public function criarNovo($params = null){
      return new CidadeEntity($params);    
    }
    
    public function criarVarios($results , $estado=null){
        $lista_cidades = array();
        foreach($results as $result){
            if(is_null($estado)){
                $dadosEstado = $this->_estadoDAO->recuperar($result['estado']);
                $result['estado'] = $dadosEstado;
            }else{
               $result['estado']=$estado;
            }
            $lista_cidades[] = $this->criarNovo($result);
        }
        if(count($lista_cidades)>1){
            $response = $lista_cidades;
        }else{
            $response = $lista_cidades[0];
        }
        return $response;
    }
    
     
    
    public function inserir($obj){
        
    }
    
    public function atualizar($obj){
        
    }
    
    public function recuperar($id){
        $adapter = $this->getAdapter();
        $sql = 'select * from cidade where(id ='.$id.')';
        $statement = $adapter->query($sql);
        $results =  $statement->execute();
        return $this->criarVarios($results);
    }
    
    public function remover($obj){
        
    }
    
    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null){
        
    } 
    
    public function recuperarPorEstado(\Application\Entity\Estado $estado){
        $adapter = $this->getAdapter();
        $sql = 'select * from cidade where(estado ='.$estado->getId().')';
        $statement = $adapter->query($sql);
        $results =  $statement->execute();
        return $this->criarVarios($results,$estado);
    }
    
    public function recuperarPorNome($nome){
        $adapter = $this->getAdapter();
        $sql = "select * from cidade where(nome ='".$nome."')";
        $statement = $adapter->query($sql);
        $results =  $statement->execute();
        return $this->criarVarios($results);
    }
}
