<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Imovel as ImovelEntity;
/**
 * Description of Imovel
 *
 * @author thiago
 */
class Imovel extends \Base\Model\AbstractModel {
    private $_imovelObj;
    
    
    public function __construct() {
        
    }
    
    public function criarNovo($params = null){
        return $this->_imovelObj = new ImovelEntity($params);
    }
    
     public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }
    
    protected function atualizar($obj) {
        
    }

    protected function inserir($obj) {
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO Imovel (bairro,rua,numero,area_total,area_construida".
                ",valor_iptu,valor_transacao,descricao,tipo_transacao,proprietario".
                ",subCategoria)VALUES('".$obj->getBairro()->getId()."','".$obj->getRua().
                "','".$obj->getNumero()."','".$obj->getAreaTotal()."','".$obj->getAreaConstruida().
                "','".$obj->getValorIptu()."','".$obj->getValorTransacao()."','".$obj->getDescricao().
                "','".$obj->getTipoTransacao()->getId()."','".$obj->getProprietario()->getId().
                "','".$obj->getSubCategoria()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return $results->getResource();//retorna os dados da inserção
    }

    protected function recuperar($obj) {
        
    }

    protected function recuperarTodos($de, $qtd, $filtro, $param) {
        
    }

    protected function remover($obj) {
        
    }

}
