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
        if(count($lista_bairros)>1){
            $response = $lista_bairros;
        }else{
            $response = $lista_bairros[0];
        }
        return $response;
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
    
    public function recuperarTodos($de=null,$qtd=null){
        if($de == null and $qtd == null){
            
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Bairro";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $bairros_list = $this->criarVarios($results, null);
        return $bairros_list;
    } 
}
