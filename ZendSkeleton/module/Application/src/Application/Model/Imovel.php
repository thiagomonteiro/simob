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
use Application\Entity\Midia as MidiaEntity;



/**
 * Description of Imovel
 *
 * @author thiago
 */
class Imovel extends \Base\Model\AbstractModel {
    private $_imovelObj;
    private $_bairroDao;
    private $_transacaoDao;
    
    public function __construct() {
        $this->_bairroDao = \Base\Model\daoFactory::factory('Bairro');
        $this->_transacaoDao = \Base\Model\daoFactory::factory('TipoTransacao');
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
        $this->_imovelObj->setNumero($params['imovel_numero']);//para nao dar conflito com o numero do proprietario
        $bairro = $this->_bairroDao->criarNovo($params);
        if(array_key_exists('imovel_status', $params)){
             $status = new \Application\Entity\ImovelStatus();
             $status->setStatus($params['imovel_status']);
             $status->setId($params['imovelstatus_id']);
             $this->_imovelObj->setImovelStatus($status);
        }
        if(array_key_exists('tipo_transacao_id', $params)){
            $tipoTransacao = new \Application\Entity\TipoTransacao();
            $tipoTransacao->setId($params['tipo_transacao_id']);
            $tipoTransacao->setDescricao($params['tipo_transacao_descricao']);
        }
        if(array_key_exists('categoria_id', $params)){
         $categoria = new \Application\Entity\CategoriaImovel();
         $categoria->setId($params['categoria_id']);
         $categoria->setDescricao($params['categoria_descricao']);
        }
        if(array_key_exists('subCategoria_id', $params)){
            $subCategoria = new \Application\Entity\SubCategoriaImovel();
            $subCategoria->setId($params['subCategoria_id']);
            $subCategoria->setDescricao($params['subCategoria_descricao']);
            $subCategoria->setCategoria($categoria);
        }
        $this->_imovelObj->setBairro($bairro);
        $this->_imovelObj->setTipoTransacao($tipoTransacao);
        $this->_imovelObj->setSubCategoria($subCategoria);
        return $this->_imovelObj;
    }
    
    public function criarVariosFromSql($results){
        $listaImovel = array();        
        foreach ($results as $row){       
            $listaImovel[] = $this->criarNovoFromSql($row);
        }
        return $listaImovel;
    }
    
    private function criarAnuncio($params){
        $dados_transacao = array('id' =>  $params['trans_id'],'descricao' => $params['trans_descricao']);
        $transacaoObj = $this->_transacaoDao->criarNovo($dados_transacao);        
        $bairroObj = $this->_bairroDao->criarNovo($params);
        $dados_imovel = array('id' => $params['imovel_id'],'descricao' => $params['imovel_descricao'], 'valorTransacao' => $params['imovel_valor'], 'bairro' => $bairroObj, 'tipoTransacao' => $transacaoObj);
        $imovelObj = $this->criarNovo($dados_imovel);
        $dados_midia = array('id' => $params['midia_id'], 'url' => $params['midia_url'], 'imovel' => $imovelObj);
        $midiaObj = new MidiaEntity($dados_midia);
        return $midiaObj;
    }

    private function criarVariosAnuncios($results){
        $list_anuncios = array();
        foreach ($results as $row){
            $list_anuncios[] = $this->criarAnuncio($row);
        }
        return $list_anuncios;
    }

    public function salvar($obj){
        if($obj->isPersistido()){
            return $this->atualizar($obj);
        }else{
            return $this->inserir($obj);
        }
    }
    public function atualizar($obj){        
    }
    
     public function atualizarPasso1($obj){        
        $adapter = $this->getAdapter();
        $sql =  "UPDATE Imovel SET descricao='".$obj->getDescricao()."',rua='".$obj->getRua()."',numero = '".$obj->getNumero()."' , bairro ='".$obj->getBairro()->getId()."',area_total=".$obj->getAreaTotal().",area_construida=".$obj->getAreaConstruida().",valor_iptu='".$obj->getValorIptu()."',valor_transacao='".$obj->getValorTransacao()."',tipo_transacao='".$obj->getTipoTransacao()->getId()."',subCategoria='".$obj->getSubCategoria()->getId()."' WHERE id=".$obj->getId();
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute(); 
        return true;
    }
    public function atualizarPasso2($obj){        
        $adapter = $this->getAdapter();
        $sql =  "UPDATE Imovel SET proprietario='".$obj->getProprietario()->getId()."' WHERE id=".$obj->getId();
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute(); 
        return true;
    }

    protected function inserir($obj) {
        $adapter =  $this->getAdapter();
        $sql = "INSERT INTO Imovel (bairro,rua,numero,area_total,area_construida".
                ",valor_iptu,valor_transacao,descricao,tipo_transacao,proprietario".
                ",subCategoria, imovelStatus)VALUES('".$obj->getBairro()->getId()."','".$obj->getRua().
                "','".$obj->getNumero()."','".$obj->getAreaTotal()."','".$obj->getAreaConstruida().
                "','".$obj->getValorIptu()."','".$obj->getValorTransacao()."','".$obj->getDescricao().
                "','".$obj->getTipoTransacao()->getId()."','".$obj->getProprietario()->getId().
                "','".$obj->getSubCategoria()->getId()."','".$obj->getImovelStatus()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        return $results->getResource();//retorna os dados da inserção
    }

    public function recuperar($id) {        
        $adapter = $this->getAdapter();        
        $sql = "SELECT Imovel.id as imovel_id, Imovel.rua as rua, Imovel.numero as imovel_numero,".
        "Imovel.area_total as area_total, Imovel.area_construida as area_construida,Imovel.valor_iptu as iptu,".
        "Imovel.valor_transacao as valor_transacao, Imovel.descricao as descricao, Bairro.id as bairro_id,".
        "Bairro.nome as bairro_nome, cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id,".
        "estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome,".
        "pais.sigla as pais_sigla ,TipoTransacao.id as tipo_transacao_id, TipoTransacao.descricao as tipo_transacao_descricao,".
        "SubCategoriaImovel.id as subCategoria_id, SubCategoriaImovel.descricao as subCategoria_descricao,".        
        "CategoriaImovel.id as categoria_id, CategoriaImovel.descricao as categoria_descricao,".
        "Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro,".
        "Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular,".
        "Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao,".
        "ImovelStatus.status as imovel_status, ImovelStatus.id as imovelstatus_id".
        " FROM Imovel INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id INNER JOIN TipoTransacao ON Imovel.tipo_transacao = TipoTransacao.id INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id INNER JOIN CategoriaImovel ON SubCategoriaImovel.categoria = CategoriaImovel.id INNER JOIN Proprietario ON Imovel.proprietario = Proprietario.id INNER JOIN ImovelStatus ON Imovel.imovelStatus = ImovelStatus.id".
        " WHERE(Imovel.id=".$id.")";        
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
        $sql = "SELECT Imovel.id as imovel_id, Imovel.rua as rua, Imovel.numero as imovel_numero,".
        "Imovel.area_total as area_total, Imovel.area_construida as area_construida,Imovel.valor_iptu as iptu,".
        "Imovel.valor_transacao as valor_transacao, Imovel.descricao as descricao, Bairro.id as bairro_id,".
        "Bairro.nome as bairro_nome, cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id,".
        "estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome,".
        "pais.sigla as pais_sigla ,TipoTransacao.id as tipo_transacao_id, TipoTransacao.descricao as tipo_transacao_descricao,".
        "SubCategoriaImovel.id as subCategoria_id, SubCategoriaImovel.descricao as subCategoria_descricao,".        
        "CategoriaImovel.id as categoria_id, CategoriaImovel.descricao as categoria_descricao,".
        "Proprietario.id as proprietario_id, Proprietario.nome as proprietario_nome, Proprietario.logradouro as logradouro,".
        "Proprietario.numero as numero, Proprietario.telefone as telefone, Proprietario.celular as celular,".
        "Proprietario.cpf as cpf, Proprietario.rg as rg, Proprietario.profissao as profissao,".
        "ImovelStatus.status as imovel_status, ImovelStatus.id as imovelstatus_id".
        " FROM Imovel INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id INNER JOIN TipoTransacao ON Imovel.tipo_transacao = TipoTransacao.id INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id INNER JOIN CategoriaImovel ON SubCategoriaImovel.categoria = CategoriaImovel.id INNER JOIN Proprietario ON Imovel.proprietario = Proprietario.id INNER JOIN ImovelStatus ON Imovel.imovelStatus = ImovelStatus.id".
        " LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();        
        $imovel_list = $this->criarVariosFromSql($results);
        return $imovel_list;
    }
    
    public function recuperarAnuncios($de = null, $qtd = null,$cidade = null, $bairro = null, $subCategoria = null, $transacao = null, $preco = null){
        if($de == null){
            $de=0;
        }
        if($qtd == null){
            $qtd=  self::$_qtd_por_pagina;//5
        }
       $where = " WHERE(Midia.capa = 1 AND ImovelStatus.status = ". \Application\Entity\TipoStatus::ATIVO;
       if($cidade != null && $cidade != 0){
           $where.=" AND cidade.id = ".$cidade;
       }
       if($bairro != null && $bairro != 0){
           $where.=" AND Bairro.id = ".$bairro;
       }
       if($subCategoria != null && $subCategoria != 0){
           $where.=" AND SubCategoriaImovel.id = ".$subCategoria;
       }
       if($transacao != null && $transacao != 0){
           $where.=" AND TipoTransacao.id = ".$transacao;
       }
       if($preco != null && $preco != 0){
           if($preco != 5){
               $valores = array(1 => 100000, 2 => 200000, 3 => 300000, 4 => 400000);
               $where.=" AND valor_transacao >= '".$valores[$preco]."' AND valor_transacao < '".($valores[$preco] + 100000) ."'";
           }else{
               $where.=" AND valor_transacao >= '". 500000 ."'";
           }  
       }
       $adapter = $this->getAdapter();
       $sql = "SELECT Imovel.id AS imovel_id, Imovel.descricao AS imovel_descricao, Imovel.valor_transacao as imovel_valor,".
       " Bairro.id AS bairro_id, Bairro.nome as bairro_nome,".
       " cidade.id as cidade_id, cidade.nome as cidade_nome, estado.id as estado_id,".
       " estado.nome as estado_nome, estado.uf as estado_uf, pais.id as pais_id, pais.nome as pais_nome,".
       " pais.sigla as pais_sigla ,TipoTransacao.id as tipo_transacao_id, TipoTransacao.descricao as tipo_transacao_descricao,".
       " TipoTransacao.id AS trans_id, TipoTransacao.descricao AS trans_descricao,".
       " SubCategoriaImovel.id AS sub_cat_id, SubCategoriaImovel.descricao AS sub_cat_descricao,".
       " ImovelStatus.status as imovel_status,".
       " Midia.id AS midia_id, Midia.url AS midia_url FROM Imovel INNER JOIN Midia".
       " ON Imovel.id = Midia.imovel INNER JOIN TipoTransacao ON TipoTransacao.id = Imovel.tipo_transacao".
       " INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id".
       " INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id".
       " INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id".
       " INNER JOIN ImovelStatus ON Imovel.imovelStatus = ImovelStatus.id".
       $where.") GROUP BY imovel_id LIMIT ".$de.", ".($qtd+1)."";
       $statement = $adapter->query($sql);
       $results = $statement->execute();
       $anuncios_list = $this->criarVariosAnuncios($results);
       return $anuncios_list;
    }
    
    public function ativarInativar($id,$status){
        $adapter = $this->getAdapter();
        $sql =  "UPDATE ImovelStatus SET status =".$status." WHERE id=".$id;
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();        
        return true;
    }
    
    
    public function remover($id) {
        $imovel = $this->recuperar($id);
        $adapter = $this->getAdapter();
        
        $sql1 = "DELETE FROM ImovelComodo WHERE(imovel =".$imovel[0]->getId().")";
        $statement1 = $adapter->query($sql1);
        $results1 = $statement1->execute();
        
        $sql2 = "DELETE FROM Midia WHERE(imovel =".$imovel[0]->getId().")";
        $statement2 = $adapter->query($sql2);
        $results2 = $statement2->execute();
        
        $sql3 = "DELETE FROM Imovel WHERE(id =".$imovel[0]->getId().")";
        $statement3 = $adapter->query($sql3);
        $results3 = $statement3->execute();
        
        $sql4 = "DELETE FROM ImovelStatus WHERE(id =".$imovel[0]->getImovelStatus()->getId().")";
        $statement4 = $adapter->query($sql4);
        $results4 = $statement4->execute();
        
    
        /*
        //consulta1
        
        //consulta2
        
        //deletar midias
        
        //deletar imovel
        */
    }

}
