<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Proprietario as ProprietarioEntity;
use Application\Entity\Bairro as BairroEntity;
use Application\Entity\Cidade as CidadeEntity;
use Application\Entity\Estado as EstadoEntity;
use Application\Entity\Pais as PaisEntity;
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
    
    public function criarVarios($results,$getBairro = null){
        $lista_proprietarios = array();
        foreach($results as $result){
            //proprietario
            $proprietario = new ProprietarioEntity();
            $proprietario->setId($result['proprietario_id']);
            $proprietario->setNome($result['proprietario_nome']);
            $proprietario->setLogradouro($result['logradouro']);
            $proprietario->setNumero($result['numero']);
            $proprietario->setTelefone($result['telefone']);
            $proprietario->setCelular($result['celular']);
            $proprietario->setCpf($result['cpf']);
            $proprietario->setRg($result['rg']);
            $proprietario->setProfissao($result['profissao']);
            if(!is_null($getBairro)){
                $bairro = new BairroEntity();
                $cidade = new CidadeEntity();
                $estado = new EstadoEntity();
                $pais = new PaisEntity();
                //pais
                $pais->setId($result['pais_id']);
                $pais->setNome($result['pais_nome']);
                $pais->setSigla($result['pais_sigla']);
                //estado
                $estado->setId($result['estado_id']);
                $estado->setNome($result['estado_nome']);
                $estado->setUf($result['estado_uf']);
                $estado->setPais($pais);
                //cidade
                $cidade->setId($result['cidade_id']);
                $cidade->setNome($result['cidade_nome']);
                $cidade->setEstado($estado);
                //bairro
                $bairro->setId($result['bairro_id']);
                $bairro->setNome($result['bairro_nome']);
                $bairro->setCidade($cidade);
                $proprietario->setBairro($bairro);
            }
            $lista_proprietarios[]=$proprietario;
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
        $proprietario = $this->criarVarios($result,true);
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
        $aux = str_replace(array(".","-"),"", $cpf);
        $adapter = $this->getAdapter();
        $sql = "SELECT Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro, Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular, Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao, Bairro.id as bairro_id, Bairro.nome as bairro_nome,cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id, estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome, pais.sigla as pais_sigla FROM Proprietario INNER JOIN Bairro on Proprietario.Bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id WHERE (Proprietario.cpf like '%".$aux."%') LIMIT ".$de.", ".($qtd+1)."";        
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
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