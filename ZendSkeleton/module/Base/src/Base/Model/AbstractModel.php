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



    protected  $config = array(
        "driver" => "Mysqli",
        "database" => "zend",
        "username" => "root",
        "password" => ""
    );

    public function getAdapter(){
        $adapter = new Adapter($this->config);
        return $adapter;
    }

    public function setDabase($database){
        $config["database"] = $database;
    }

    public function getInstanceEntity(){

    }

    abstract protected function insert($obj);
    abstract protected function update($obj);
    abstract protected function select($obj);
    abstract protected function delete($obj);
    abstract protected function getAll($de,$qtd);

}