<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Imovel as ImovelEntity;
use Application\Entity\CategoriaImovel as CategoriaEntity;
use Application\Entity\SubCategoriaImovel as SubCategoriaEntity;
use Application\Entity\Proprietario as ProprietarioEntity;
use Application\Model\Bairro as BairroModel;


/**
 * Description of Imovel
 *
 * @author thiago
 */
class Imovel extends \Base\Model\AbstractModel {
    private $_imovelObj;
    private $_bairroDao;
    
    public function __construct() {
        $this->_bairroDao = new BairroModel();
    }
    
    public function criarNovo($params = null){
         return $this->_imovelObj = new ImovelEntity($params);
     }

     public function criarVarios($results,$proprietario = null,$bairro = null){
          $listaImovel = array();
         foreach ($results as $row){
              if(is_null($proprietario)){
                    $row['proprietario'] = $this->_proprietarioDao->recuperar($row['proprietario']);
                }else{
                    $row['proprietario'] = $proprietario;
                }
              if(is_null($bairro)){
                    $row['bairro'] = $this->_bairroDao->recuperar($row['bairro']);
                }else{
                    $row['bairro'] = $bairro;
                }
            $listaImovel[] = $this->criarNovo($row);
         }
         return $listaImovel;
     }
    
    public function criarNovoFromSql($params = null){
        $this->_imovelObj = new ImovelEntity($params);    
        $this->_imovelObj->setId($params['imovel_id']);
        $this->_imovelObj->setAreaTotal($params['area_total']);
        $this->_imovelObj->setAreaConstruida($params['area_construida']);
        $this->_imovelObj->setValorIptu($params['iptu']);
        $this->_imovelObj->setValorTransacao($params['valor_transacao']);
        $bairro = $this->_bairroDao->criarNovo($params);
        $this->_imovelObj->setBairro($bairro);
        return $this->_imovelObj;
    }
    
    public function criarVariosFromSql($results){
        $listaImovel = array();        
        foreach ($results as $row){            
            $listaImovel[] = $this->criarNovoFromSql($row);
        }
        return $listaImovel;
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

    public function recuperar($id) {        
        $adapter = $this->getAdapter();        
        $sql = "SELECT Imovel.id as imovel_id, Imovel.rua as rua, Imovel.numero as numero,".
        "Imovel.area_total as area_total, Imovel.area_construida as area_construida,Imovel.valor_iptu as iptu,".
        "Imovel.valor_transacao as valor_transacao, Imovel.descricao as descricao, Bairro.id as bairro_id,".
        "Bairro.nome as bairro_nome, cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id,".
        "estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome,".
        "pais.sigla as pais_sigla ,TipoTransacao.id as tipo_transacao_id, TipoTransacao.descricao as tipo_transacao_descricao,".
        "SubCategoriaImovel.id as subCategoria_id, SubCategoriaImovel.descricao as subCategoria_descricao,".        
        "CategoriaImovel.id as categoria_id, CategoriaImovel.descricao as categoria_descricao,".
        "Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro,".
        "Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular,".
        "Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao".
        " FROM Imovel INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id INNER JOIN TipoTransacao ON Imovel.tipo_transacao = TipoTransacao.id INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id INNER JOIN CategoriaImovel ON SubCategoriaImovel.categoria = CategoriaImovel.id INNER JOIN Proprietario ON Imovel.proprietario = Proprietario.id WHERE(Imovel.id=".$id.")";
        $statement = $adapter->query($sql);
        $results = $statement->execute();        
        $imovel_list = $this->criarVariosFromSql($results);
        return $imovel_list;
    }

    public function recuperarTodos($de=null, $qtd=null, $filtro=null, $param=null) {
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd=  self::$_qtd_por_pagina;
        }
        $adapter = $this->getAdapter();        
        $sql = "SELECT Imovel.id as imovel_id, Imovel.rua as rua, Imovel.numero as numero,".
        "Imovel.area_total as area_total, Imovel.area_construida as area_construida,Imovel.valor_iptu as iptu,".
        "Imovel.valor_transacao as valor_transacao, Imovel.descricao as descricao, Bairro.id as bairro_id,".
        "Bairro.nome as bairro_nome, cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id,".
        "estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome,".
        "pais.sigla as pais_sigla ,TipoTransacao.id as tipo_transacao_id, TipoTransacao.descricao as tipo_transacao_descricao,".
        "SubCategoriaImovel.id as subCategoria_id, SubCategoriaImovel.descricao as subCategoria_descricao,".        
        "CategoriaImovel.id as categoria_id, CategoriaImovel.descricao as categoria_descricao,".
        "Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro,".
        "Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular,".
        "Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao".
        " FROM Imovel INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id INNER JOIN TipoTransacao ON Imovel.tipo_transacao = TipoTransacao.id INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id INNER JOIN CategoriaImovel ON SubCategoriaImovel.categoria = CategoriaImovel.id INNER JOIN Proprietario ON Imovel.proprietario = Proprietario.id".        
        " LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();        
        $imovel_list = $this->criarVariosFromSql($results);
        return $imovel_list;
    }

    protected function remover($obj) {
        
    }

}
