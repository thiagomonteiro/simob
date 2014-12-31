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
    }
    public function criarNovo($params = null){
        $paisModel = new PaisModel();
        $estadoObj = new EstadoEntity();   
        $paramsPais = array('id'=>$params['pais_id'],'nome' => $params['pais_nome'], 'sigla' => $params['pais_sigla']);
        $paisObj = $paisModel->criarNovo($paramsPais);
        $estadoObj->setId($params['estado_id']);
        $estadoObj->setNome($params['estado_nome']);
        $estadoObj->setUf($params['estado_uf']);
        $estadoObj->setPais($paisObj);
        return $estadoObj;
    }
    
    public function criarVarios($results,$pais=null){
        $lista_estados = array();
        foreach($results as $result){
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
        $sql= "SELECT estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM estado INNER JOIN pais ON estado.pais = pais.id where(estado.id ='".$id."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        return $this->criarVarios($results);
    }
    
    public function recuperarPorUf($uf){       
        $adapter = $this->getAdapter();
        $sql = "SELECT estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM estado INNER JOIN pais ON estado.pais = pais.id where(uf ='".$uf."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return $this->criarVarios($results);
    }
    
    public function remover($obj){
        
    }
    
    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null){
        if($de == null and $qtd == null){
            $adapter = $this->getAdapter();
            $sql = "SELECT estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM estado INNER JOIN pais ON estado.pais = pais.id where(pais.id = 1)";
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            $this->fecharConexao();
            return $this->criarVarios($results);
        }
    }
}