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
    }
    
    public function criarNovo($params = null){
            $cidadeObj= new CidadeEntity();
            $estadoDao = new EstadoModel();
            $estadoObj = $estadoDao->criarNovo($params);
            //cidade
            $cidadeObj->setId($params['cidade_id']);
            $cidadeObj->setNome($params['cidade_nome']);
            //relaçoes            
            $cidadeObj->setEstado($estadoObj);
            return $cidadeObj;
    }
    
    public function criarVarios($results){
        $lista_cidades = array();
        foreach($results as $result){
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
        $sql = "SELECT cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM cidade INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id where(cidade.id =".$id.")";
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
        $sql = "SELECT cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM cidade INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id where(estado =".$estado->getId().")";
        $statement = $adapter->query($sql);
        $results =  $statement->execute();
        return $this->criarVarios($results,$estado);
    }
    
    public function recuperarPorNome($nome){
        $adapter = $this->getAdapter();
        $sql = "SELECT cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM cidade INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id where(cidade.nome ='".$nome."')";
        $statement = $adapter->query($sql);
        $results =  $statement->execute();
        return $this->criarVarios($results);
    }
}
