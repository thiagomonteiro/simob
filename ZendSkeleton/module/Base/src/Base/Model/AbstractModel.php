<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrador
 * Date: 21/10/13
 * Time: 15:54
 * To change this template use File | Settings | File Templates.
 */

namespace Base\Model;

use Zend\Db\Sql\Sql;  //classe que executa query
use Zend\Db\Adapter\Adapter; // classe que conecta ao banco de dados

abstract class AbstractModel {
    
    protected static $_qtd_por_pagina=5;

    protected  $config = array(
        "driver" => "Mysqli",
        "database" => "zend",
        "username" => "root",
        "password" => ""
    );

    protected function getAdapter(){
        $adapter = new Adapter($this->config);
        return $adapter;
    }

    public function setDabase($database){
        $config["database"] = $database;
    }

    public function getInstanceEntity(){

    }

     public function save($obj){
        if($obj->isPersistido()) {
            $this->update($obj);
        }else{
            $this->insert($obj);
        }
    }
    abstract protected function inserir($obj);
    abstract protected function atualizar($obj);
    abstract protected function recuperar($obj);
    abstract protected function remover($obj);
    abstract protected function recuperarTodos($de,$qtd,$filtro,$param);

}