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
    private $_ImovelDao;


    public function __construct() {
        $this->_ImovelDao = \Base\Model\daoFactory::factory('Imovel');
    }
    
    public function criarNovo($params = null){
        return $this->_ImovelMidia = new MidiaEntity($params);
    }
    
    public function criarVarios($results, $imovel = null){
        $listaMidia = array();
        foreach ($results as $row){
            if(is_null($imovel)){
               $row['imovel'] = $this->_ImovelDao->recuperar($row['imovel']);
            }else{
                $row['imovel'] = $imovel;
            }
            $listaMidia[]= $this->criarNovo($row);
        }
        if(count($listaMidia)== 1){
            return $listaMidia[0];
        }else{
            return $listaMidia;
        }
        
    }
    
    public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }
    
    protected function atualizar($obj) {
        $adapter =  $this->getAdapter();
        $sql = "UPDATE Midia SET nome ='".$obj->getNome()."' WHERE id=".$obj->getId();
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return true;
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

    public function recuperar($id) {
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Midia WHERE(id=".$id.")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $midias_list = $this->criarVarios($results);
        return $midias_list;
    }

    public function recuperarTodos($de, $qtd, $filtro, $param) {
        if($de == null){
            $de = 0;
        }
        if($qtd == null){
            $qtd = 100;
        }
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Midia WHERE(".$filtro."='".$param."') LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $midias_list = $this->criarVarios($results);
        return $midias_list;
    }
    
    public function recuperarTotal($id){
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Midia WHERE(imovel= '".$id."')";
        $statement = $adapter->query($sql);
        $result = $statement->execute();
        $total = count($this->criarVarios($result));
        return $total;
    }

    public function remover($id) {
        $obj = $this->recuperar($id);
        unlink($_SERVER['DOCUMENT_ROOT'].$obj->getUrl());
        try{
        $adapter = $this->getAdapter();
        $sql = "DELETE FROM Midia WHERE(id =".$id.")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
           return "ok";
         }catch(\Zend\Db\Adapter\Exception\RuntimeException $e){
           return "Não foi possível excluir, este Comodo faz referência a um imóvel ou proprietario";
       }
    }

}
