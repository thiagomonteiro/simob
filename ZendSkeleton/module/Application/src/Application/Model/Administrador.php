<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

use Application\Entity\Administrador as AdmEntity;


class Administrador extends \Base\Model\AbstractModel{

private $classe = "\\Application\\Entity\\Administrador"; // este valor será modificado sempre



    public function insert($obj)
    {
        try {
            $adapter =  $this->getAdapter();
            $sql = "INSERT INTO Administrador (nome, email, senha)VALUES ('".$obj->getNome()."','".$obj->getEmail()."','".$obj->getSenha()."')";
            $statement = $adapter -> query($sql);
            $results = $statement -> execute();
            return true;
        }catch(\Exception $e){
            return false;
            }
    }

    public function update($obj)
    {
    }

    public function select($obj)
    {
        try {
            $adapter = $this->getAdapter();
            $sql = "SELECT * FROM Administrador WHERE(email ='".$obj->getEmail()."')";
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            $lista_usuario = array();
            foreach($results as $result){
                $lista_usuario[] = new AdmEntity($result);
            }
            return $lista_usuario;
        }catch (\Exception $e){
            return false;
        }
    }

    public function selectLogin($obj){ 
        try {
            $adapter = $this->getAdapter();
            $sql = "SELECT * FROM Administrador WHERE(email ='".$obj->getEmail()."' and senha='".$obj->getSenha()."')";
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            $lista_usuario = array();
            foreach($results as $result){
                $lista_usuario[] = new AdmEntity($result);
            }
            return $lista_usuario;
        }catch (\Exception $e){
            return false;
        }
    }

    public function delete($obj)
    {
    }

    public function getAll($de,$qtd)
    {
        echo $qtd;
        if($qtd ==  null){
            $qtd=10;
        }
        if($de == null){
            $de=0;
        }
        try {
            $adapter = $this->getAdapter();

            $sql = "SELECT * FROM Administrador LIMIT $de,$qtd";
            $statement = $adapter->query($sql);
            $results =  $statement->execute();
            $lista_usuario = array();
            foreach($results as $result){
                $obj = new $this->classe($result);//instanciando um objeto
                $lista_usuario[] = $obj;
            }
            return $lista_usuario;
        }catch (\Exception $e){
            return false;
        }

    }

}