<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Proprietario as ProprietarioEntity;
/**
 * Description of Proprietario
 *
 * @author thiago
 */
class Proprietario extends \Base\Model\AbstractModel{
    private $_proprietarioObj;
    
    public function criarNovo($params = null){
        return $this->_proprietarioObj = new ProprietarioEntity($params);
    }
    
    public function criarVarios($results){
        
    }
    
    
    
    protected function atualizar($obj) {
        
    }

    protected function inserir($obj) {
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO Proprietario (nome,bairro,logradouro,numero,telefone,"
                . "celular,cpf,rg,profissao)VALUES('".$obj->getNome()."','".$obj->getBairro()->getId()
                ."','".$obj->getLogradouro()."','".$obj->getNumero()."','".$obj->getTelefone()."','"
                .$obj->getCelular()."','".$obj->getCpf()."','".$obj->getRg()."','".$obj->getProfissao()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
    }
    
    public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }

    protected function recuperar($obj) {
        
    }

    protected function recuperarTodos($de, $qtd, $filtro, $param) {
        
    }

    protected function remover($obj) {
        
    }

}
