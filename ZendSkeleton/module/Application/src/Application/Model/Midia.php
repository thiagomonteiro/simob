<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Midia as MidiaEntity;
/**
 * Description of Midia
 *
 * @author thiago
 */
class Midia extends \Base\Model\AbstractModel {
    private $_ImovelMidia;
    
    public function __construct() {

    }
    
    public function criarNovo($params = null){
        return $this->_ImovelMidia = new MidiaEntity($params);
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
        $sql = "INSERT INTO Midia (url,posicao,nome,tipo,imovel)".
                "VALUES('".$obj->getUrl()."','".$obj->getPosicao().
                "','".$obj->getNome()."','".$obj->getTipo()."','".$obj->getImovel()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return $results->getResource();//retorna os dados da inserção
    }

    protected function recuperar($obj) {
        
    }

    protected function recuperarTodos($de, $qtd, $filtro, $param) {
        
    }

    protected function remover($obj) {
        
    }

}
