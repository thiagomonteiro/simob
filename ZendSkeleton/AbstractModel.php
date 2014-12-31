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
use Zend\Db\Adapter\Driver\Mysqli\Connection;

abstract class AbstractModel {
    
    protected static $_qtd_por_pagina=5;
    private $adapter;
    private $conexao;
    protected  $config = array(
        /*"driver" => "Mysqli",
        "database" => "zend",
        "username" => "root",
        "password" => ""*/
        "driver" => "Mysqli",
        "database" => "lagosbyte",
        "username" => "lagosbyte",
        "host" => "dbmy0037.whservidor.com",
        "password" => "tfdm18"
    );

    protected function getAdapter(){
        $this->adapter = new Adapter($this->config);
        return $this->adapter;
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
    
    protected function fecharConexao(){
        $this->conexao = new Connection();
        $this->conexao->disconnect();
    }

    abstract protected function inserir($obj);
    abstract protected function atualizar($obj);
    abstract protected function recuperar($obj);
    abstract protected function remover($obj);
    abstract protected function recuperarTodos($de,$qtd,$filtro,$param);

}
