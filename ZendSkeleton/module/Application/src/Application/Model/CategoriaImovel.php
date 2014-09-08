<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\CategoriaImovel as CategoriaEntity;
/**
 * Description of TipoImovel
 *
 * @author administrador
 */
class CategoriaImovel extends \Base\Model\AbstractModel{
    
    public function __construct() {
    }
    
    public function criarNovo($params){
        return new CategoriaEntity($params);
    }
    
    public function criarVarios($results){
        $lista = array();
        foreach ($results as $result){
            $lista[] = $this->criarNovo($result);
        }
        return $lista;
    }
    
    protected function atualizar($obj) {
        
    }

    protected function inserir($obj) {
        
    }

    protected function recuperar($id) {
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM CategoriaImovel WHERE( id =".$id.")";
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $lista = $this->criarVarios($result);
        return $lista[0];
    }

    public function recuperarTodos($de = null, $qtd = null, $filtro = null, $param = null) {
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM CategoriaImovel";
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $lista = $this->criarVarios($result);
        return $lista;
    }

    protected function remover($obj) {
        
    }

}
