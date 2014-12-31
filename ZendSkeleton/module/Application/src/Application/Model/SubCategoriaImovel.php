<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\SubCategoriaImovel as SubCategoriaEntity;
use Application\Model\CategoriaImovel as categoriaModel;
/**
 * Description of SubCategoriaImovel
 *
 * @author administrador
 */
class SubCategoriaImovel extends \Base\Model\AbstractModel {
    private $_categoriaDao;
    
    public function __construct() {
        $this->_categoriaDao = new categoriaModel();
    }
    
    public function criarNovo($params){
       return new SubCategoriaEntity($params);
    }
    
    public function criarVarios($results){
        $lista = array();
        foreach ($results as $row){
            $row['categoria'] = $this->_categoriaDao->recuperar($row['categoria']);
            $lista[] = $this->criarNovo($row);  
        }
        return $lista;
    }
    
    public function atualizar($obj) {
        
    }

    public function inserir($obj) {
        
    }
    
    public function salvar($obj){
        
    }

    public function recuperar($idSubCategoria) {
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM SubCategoriaImovel WHERE(id =".$idSubCategoria.")";
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $this->fecharConexao();
        $lista = $this->criarVarios($result);
        return $lista[0];
    }
    
    public function recuperarTodosPorCategoria($idCategoria){
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM SubCategoriaImovel WHERE(categoria =".$idCategoria.")";
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $this->fecharConexao();
        $lista = $this->criarVarios($result);
        return $lista;
    }

    public function recuperarTodos($de = null, $qtd = null, $filtro = null, $param = null) {
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM SubCategoriaImovel";
        $statement = $adapter->createStatement($sql);
        $result = $statement->execute();
        $this->fecharConexao();
        $lista = $this->criarVarios($result);
        return $lista;
    }

    public function remover($obj) {
        
    }

}
