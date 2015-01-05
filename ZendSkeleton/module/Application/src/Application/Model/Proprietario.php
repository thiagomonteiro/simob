<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Proprietario as ProprietarioEntity;
use Application\Model\Bairro as BairroModel;
/**
 * Description of Proprietario
 *
 * @author thiago
 */
class Proprietario extends \Base\Model\AbstractModel{
    private $_proprietarioObj;
    private $_bairroDao;
    
    public function __construct() {
        $this->_bairroDao = new BairroModel();
    }
    
    public function criarNovo($params = null){
        return $this->_proprietarioObj = new ProprietarioEntity($params);
    }

    public function criarNovoFromSql($params, $getBairro = null){
            $data = array('id' => $params['proprietario_id'], 'nome' => $params['proprietario_nome'],
            'logradouro' => $params['logradouro'], 'numero' => $params['numero'],
            'telefone' => $params['telefone'], 'celular' => $params['celular'],
            'cpf' => $params['cpf'], 'rg' => $params['rg'], 'profissao' => $params['profissao']);
            $proprietario = new ProprietarioEntity($data);
            if(!is_null($getBairro)){// se for diferente de de nulo ou seja $this->criarVarios($result,true), ele vai buscar os bairros, senha so retorna os dados do usuario
                $bairro = $this->_bairroDao->criarNovo($params);
                $proprietario->setBairro($bairro);
            }
            return $proprietario;
    }
    
    public function criarVariosFromSql($results,$getBairro = null){
        $lista_proprietarios = array();
        foreach($results as $result){
            $lista_proprietarios[]=  $this->criarNovoFromSql($result,$getBairro);
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
        $sql = "SELECT Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro, Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular, Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao, Bairro.id as bairro_id, Bairro.nome as bairro_nome,cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id, estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome, pais.sigla as pais_sigla FROM Proprietario INNER JOIN Bairro on Proprietario.Bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE(Proprietario.id =".$id.")";        
        $statement = $adapter->query($sql);   
        $result = $statement->execute();      
        $proprietario = $this->criarVariosFromSql($result,true);
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
        $sql = "SELECT Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro, Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular, Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao, Bairro.id as bairro_id, Bairro.nome as bairro_nome,cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id, estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome, pais.sigla as pais_sigla FROM Proprietario INNER JOIN Bairro on Proprietario.Bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id LIMIT ".$de.", ".($qtd+1)."";        
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();        
        $lista = $this->criarVariosFromSql($results);
        return $lista;
    }
   
    public function recuperarPorCpf($cpf,$de=null,$qtd=null){
       if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        } 
        $aux = str_replace(array(".","-"),"", $cpf);
        $adapter = $this->getAdapter();
        $sql = "SELECT Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro, Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular, Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao, Bairro.id as bairro_id, Bairro.nome as bairro_nome,cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id, estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome, pais.sigla as pais_sigla FROM Proprietario INNER JOIN Bairro on Proprietario.Bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE (Proprietario.cpf like '%".$aux."%') LIMIT ".$de.", ".($qtd+1)."";        
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        $lista = $this->criarVariosFromSql($results);
        return $lista;
    }
    
    public function recuperarPorParametro($de = null, $qtd = null, $filtro, $param){
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        }
        $where;
        if($filtro == "cpf"){
           $param = str_replace(array(".","-"),"", $param);
           $where ="WHERE (Proprietario.cpf like '%".$param."%')";
        }
        if($filtro == "nome"){
           $where ="WHERE (Proprietario.nome like '%".$param."%')";
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro, Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular, Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao, Bairro.id as bairro_id, Bairro.nome as bairro_nome,cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id, estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome, pais.sigla as pais_sigla FROM Proprietario INNER JOIN Bairro on Proprietario.Bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id ".$where." LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        $lista = $this->criarVariosFromSql($results);
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