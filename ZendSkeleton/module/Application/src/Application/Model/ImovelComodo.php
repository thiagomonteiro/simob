<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of ImovelComodo
 *
 * @author thiago
 */
class ImovelComodo extends \Base\Model\AbstractModel {
    private $_imovelComodo;
    
    public function __construct() {

    }
    
    public function criarNovo($imovel,$comodo,$qtd){
        $this->_imovelComodo = new \Application\Entity\ImovelComodo();
        $this->_imovelComodo->setImovel($imovel);
        $this->_imovelComodo->setTipoComodo($comodo);
        $this->_imovelComodo->setQtd($qtd);
        return $this->_imovelComodo;
    }
    
    public function criarVarios($results){
        $comodosArray= array();
        foreach ($results as $row){
            $tipoComodo = new \Application\Entity\TipoComodos();
            $tipoComodo->setDescricao($row['TipoComodos_descricao']);
            $this->_imovelComodo = new \Application\Entity\ImovelComodo();
            $this->_imovelComodo->setTipoComodo($tipoComodo);
            $this->_imovelComodo->setQtd($row['ImovelComodo_qtd']);
            $comodosArray[]=  $this->_imovelComodo;
        }
        return $comodosArray;
    }

    public function salvar($arrayObj){
        foreach ( $arrayObj as $row){
            if($row->isPersistido()){
                $this->atualizar($row);
            }else{
                $this->inserir($row);
            }
        }
        return true;
    }
    
    protected function atualizar($obj) {
        
    }

    protected function inserir($obj) {        
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO ImovelComodo (qtd,imovel,comodo)VALUES('".$obj->getQtd()."','".$obj->getImovel()->getId()."','".$obj->getTipoComodo()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
    }

    protected function recuperar($obj) {
        
    }

    protected function recuperarTodos($de, $qtd, $filtro, $param) {
        
    }

    protected function remover($obj) {
        
    }
    
    public function recuperarPorImovel($imovel){
        $adapter = $this->getAdapter();
        $sql = "SELECT TipoComodos.descricao as TipoComodos_descricao, ImovelComodo.qtd  as ImovelComodo_qtd from TipoComodos INNER JOIN ImovelComodo ON TipoComodos.id = ImovelComodo.comodo WHERE (ImovelComodo.imovel =".$imovel->getId().")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();         
        $this->fecharConexao();
        $comodos_list = $this->criarVarios($results, null);
        return $comodos_list;        
    }

}
