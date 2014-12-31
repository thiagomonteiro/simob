<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of bairro
 *
 * @author thiago
 */

namespace Application\Model;
use \Application\Entity\Bairro as BairroEntity;
use \Application\Entity\Cidade as CidadeEntity;
use \Application\Entity\Estado as EstadoEntity;
use \Application\Entity\Pais as PaisEntity;
use \Application\Model\Cidade as CidadeModel;

class Bairro extends \Base\Model\AbstractModel {
    private $_bairroObj;
    private $_cidadeDao;
    
    public function __construct() {
        $this->_bairroObj = new BairroEntity();
        $this->_cidadeDao = new CidadeModel();
    }
    
    
    public function criarNovo($params = null){
        
        return $this->_bairroObj = new BairroEntity($params);
        
    }
    
    public function criarVarios($results,$cidade = null){
        $lista_bairros = array();
        foreach($results as $result){
            ///bairro
            $bairro = new BairroEntity();
            $bairro->setId($result['bairro_id']);
            $bairro->setNome($result['bairro_nome']);
            //cidade
            $cidade = new CidadeEntity();
            $cidade->setId($result['cidade_id']);
            $cidade->setNome($result['cidade_nome']);
            //estado
            $estado = new EstadoEntity();
            $estado->setId($result['estado_id']);
            $estado->setNome($result['estado_nome']);
            $estado->setUf($result['estado_uf']);
            //pais
            $pais = new PaisEntity();
            $pais->setId($result['pais_id']);
            $pais->setNome($result['pais_nome']);
            $pais->setSigla($result['pais_sigla']);
            
            $estado->setPais($pais);
            $cidade->setEstado($estado);
            $bairro->setCidade($cidade);
            $lista_bairros[]=$bairro;
        }

        return $lista_bairros;
    }
    
    
    public function inserir($obj){
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO Bairro (nome,cidade)VALUES('".$obj->getNome()."','".$obj->getCidade()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
    }
    
    public function atualizar($obj){        
        $adapter = $this->getAdapter();
        $sql =  "UPDATE Bairro SET nome ='".$obj->getNome()."',cidade='".$obj->getCidade()->getId()."' WHERE id=".$obj->getId();
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();        
        return true;
    }
    
    public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }
    
    public function recuperar($id){
        $adapter = $this->getAdapter();
        $sql = "SELECT Bairro.id AS bairro_id, Bairro.nome AS bairro_nome, cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM Bairro INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE (Bairro.id ='".$id."')";
        $statement = $adapter->query($sql);
        $result = $statement->execute();              
        $bairro = $this->criarVarios($result);
        return $bairro[0];
    }
    
    public function remover($id)
    {
       try{
        $adapter = $this->getAdapter();
        $sql = "DELETE FROM Bairro WHERE(id =".$id.")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return "ok";
       }catch(\Zend\Db\Adapter\Exception\RuntimeException $e){
           return "Não foi possível excluir, este Bairro faz referência a um imóvel ou proprietario";
       }
    }
    
    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null){
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd=  self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT Bairro.id AS bairro_id, Bairro.nome AS bairro_nome, cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM Bairro INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $bairros_list = $this->criarVarios($results, null);
        return $bairros_list;
    }
    
    public function recuperarPorCidade($cidade){
        $adapter = $this->getAdapter();
        $sql = "SELECT Bairro.id AS bairro_id, Bairro.nome AS bairro_nome, cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM Bairro INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE (cidade ='".$cidade->getId()."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();                 
        $bairros_list = $this->criarVarios($results, null);
        return $bairros_list;
        
    }
    
    //manter essa por causa das requisicoes
    public function recuperarPorParametro($de=null,$qtd=null,$filtro=null,$param=null){    
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd= self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        if($filtro == "cidade"){
            $cidade = $this->_cidadeDao->recuperar($param);
            $sql = "SELECT Bairro.id AS bairro_id, Bairro.nome AS bairro_nome, cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM Bairro INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE (".$filtro."='".$cidade->getId()."') LIMIT ".$de.", ".($qtd+1)."";           
        }
        if($filtro == "nome"){            
           $sql = "SELECT Bairro.id AS bairro_id, Bairro.nome AS bairro_nome, cidade.id AS cidade_id ,cidade.nome AS cidade_nome, estado.id AS estado_id, estado.nome AS estado_nome, estado.uf AS estado_uf, pais.id AS pais_id, pais.nome AS pais_nome, pais.sigla AS pais_sigla FROM Bairro INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE (Bairro.nome like '%".$param."%') LIMIT ".$de.", ".($qtd+1)."";
        }        
        $statement = $adapter->query($sql);
        $results = $statement->execute();                 
        $bairros_list = $this->criarVarios($results, null);
        return $bairros_list;
    }
}
