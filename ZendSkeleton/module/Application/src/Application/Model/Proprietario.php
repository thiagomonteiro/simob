<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Proprietario as ProprietarioEntity;
/**
 * Description of Proprietario
 *
 * @author thiago
 */
class Proprietario extends \Base\Model\AbstractModel{
    private $_proprietarioObj;
    private $_bairroDao;
    
    public function __construct() {
        $this->_bairroDao = \Base\Model\daoFactory::factory('Bairro');
    }
    
    public function criarNovo($params = null){
        return $this->_proprietarioObj = new ProprietarioEntity($params);
    }
    
    public function criarVarios($results){
        $lista_proprietarios = array();
        foreach($results as $result){
            $dadosBairro = $this->_bairroDao->recuperar($result['bairro']);
            $result['bairro'] = $dadosBairro;
            $lista_proprietarios[] = $this->criarNovo($result);
        }
        return $lista_proprietarios;
    }
    
    
    
    protected function atualizar($obj) {
        $adapter = $this->getAdapter();
        $sql =  "UPDATE Proprietario SET nome ='".$obj->getNome()."', "
                ."bairro ='".$obj->getBairro()->getId()."', logradouro = '".$obj->getLogradouro()
                ."', numero = '".$obj->getNumero()."' , telefone = '".$obj->getTelefone()."',"
                . "celular= '".$obj->getCelular()."', rg = '".$obj->getRg()."',"
                ."profissao = '".$obj->getProfissao()."' WHERE id=".$obj->getId();
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
    }

    protected function inserir($obj) {
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO Proprietario (nome,bairro,logradouro,numero,telefone,"
                . "celular,cpf,rg,profissao)VALUES('".$obj->getNome()."','".$obj->getBairro()->getId()
                ."','".$obj->getLogradouro()."','".$obj->getNumero()."','".$obj->getTelefone()."','"
                .$obj->getCelular()."','".$obj->getCpf()."','".$obj->getRg()."','".$obj->getProfissao()."')";
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

    public function recuperar($id) {
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Proprietario WHERE(id =".$id.")";
        $statement = $adapter->query($sql);
        $result = $statement->execute();      
        $proprietario = $this->criarVarios($result);
        return $proprietario[0]; 
    }

    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null) {
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Proprietario LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $lista = $this->criarVarios($results);
        return $lista;
    }
    
    public function recuperarPorCpf($cpf,$de=null,$qtd=null){
       if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        } 
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Proprietario WHERE (cpf =".$cpf.") LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $lista = $this->criarVarios($results);
        return $lista;
    }
    
    public function recuperarPorParametro($de = null, $qtd = null, $filtro, $param){
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        } 
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Proprietario WHERE (".$filtro." like '%".$param."%') LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $lista = $this->criarVarios($results);
        return $lista;
    }

    public function remover($id){
        $adapter = $this->getAdapter();
        $sql = "DELETE FROM Proprietario WHERE(id =".$id.")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        return true;
    }

}
