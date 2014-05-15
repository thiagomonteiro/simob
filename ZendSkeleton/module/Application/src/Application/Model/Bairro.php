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
use Application\Model\Cidade as CidadeModel;

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
    
    public function criarVarios($results,$cidade){
        $lista_bairros = array();
        foreach($results as $result){
            if(is_null($cidade)){
                $dadosCidade = $this->_cidadeDao->recuperar($result['cidade']);
                $result['cidade'] = $dadosCidade;
            }else{
               $result['cidade']=$cidade;
            }
            $lista_bairros[] = $this->criarNovo($result);
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
        
    }
    
    public function recuperar($obj){
        
    }
    
    public function remover($obj){
        
    }
    
    public function recuperarTodos($de=null,$qtd=null,$filtro=null,$param=null){
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd=5;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Bairro LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $bairros_list = $this->criarVarios($results, null);
        return $bairros_list;
    }
    
    public function recuperarPaginacao($de=null,$qtd=null,$filtro=null,$param=null){
        if($de == null and $qtd == null){
            $adapter = $this->getAdapter();
            if($filtro==null){
                $sql = "SELECT * FROM Bairro";
            }else{
                $sql = "SELECT * FROM Bairro WHERE(".$filtro."=".$param.")"; 
            }
            $statement = $adapter->query($sql);
            $results = $statement->execute();            
            $bairros_list = $this->criarVarios($results, null);
        }
        return $bairros_list;
    }
    
    public function recuperarPorParametro($de=null,$qtd=null,$filtro=null,$param=null){
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd=5;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Bairro WHERE(".$filtro."=".$param.") LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $bairros_list = $this->criarVarios($results, null);
        return $bairros_list;
    }
}
