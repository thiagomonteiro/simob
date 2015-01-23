<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of ImovelStatus
 *
 * @author thiago
 */
class ImovelStatus extends \Base\Model\AbstractModel{
    private $_imovelStatus;
    
     public function criarNovo($dados = array()){
        $this->_imovelStatus = new \Application\Entity\ImovelStatus();
        return $this->_imovelStatus;
    }
    
    public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }
    
    protected function atualizar($obj) {
        
    }

    protected function inserir($obj) {
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO ImovelStatus (status) VALUES ('".$obj->getImovelStatus()->getStatus()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $status = $this->criarNovo();
        $status->setId($results->getResource()->insert_id);
        return $status; // retorna um objeto com os dados
    }

    protected function recuperar($obj) {
        
    }

    protected function recuperarTodos($de, $qtd, $filtro, $param) {
        
    }

    protected function remover($obj) {
        
    }

}
