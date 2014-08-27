<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Application\Entity\TipoTransacao as TipoEntity;
/**
 * Description of TipoTransacao
 *
 * @author thiago
 */
class TipoTransacao extends \Base\Model\AbstractModel {
    
    
    public function __construct(){
        
    }
    
    public function criarNovo($params = null){
        return new TipoEntity($params);
    }
    
    public function criarVarios($results){
        $Lista = [];
        foreach($results as $result){
            $Lista[] = $this->criarNovo($result);
        }
        return $Lista;
    }
    
    public function atualizar($obj) {
        
    }

    public function inserir($obj) {
        
    }

    public function recuperar($obj) {
        
    }

    public function recuperarTodos($de = null, $qtd = null, $filtro = null, $param = null) {
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM TipoTransacao";
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $lista = $this->criarVarios($result);
        return $lista;
    }

    public function remover($obj) {
        
    }

}
