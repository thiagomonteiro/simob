<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Midia as MidiaEntity;
use Application\Entity\TipoMidia;
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
    
    public function criarNovoFromSql($params = null,$imovel = null){
        $this->_ImovelMidia = new MidiaEntity($params);
        $this->_ImovelMidia->setId($params['midia_id']);
        $this->_ImovelMidia->setNome($params['midia_nome']);
        $this->_ImovelMidia->setUrl($params['midia_url']);
        $this->_ImovelMidia->setCapa($params['midia_capa']);
        $this->_ImovelMidia->setTipo($params['midia_tipo']);
        if(is_null($imovel)){
            $this->_ImovelMidia->setImovel($this->_ImovelDao->criarNovoFromSql($params));
        }else{
            $this->_ImovelMidia($imovel);
        }
        return $this->_ImovelMidia;
    }
    
    public function criarVariosFromSql($results, $imovel = null){
        $listaMidia = array();
        foreach ($results as $row){
            $listaMidia[]= $this->criarNovoFromSql($row);
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
        $sql = "INSERT INTO Midia (url,nome,tipo,capa,imovel)".
                "VALUES('".$obj->getUrl().
                "','".$obj->getNome()."','".$obj->getTipo()."','".$obj->getCapa()."','".$obj->getImovel()->getId()."')";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        return $results->getResource();//retorna os dados da inserção
    }

    public function recuperar($id) {
        $adapter = $this->getAdapter();
        $sql = "SELECT Midia.id as midia_id, Midia.url as midia_url, Midia.capa as midia_capa, Midia.nome as midia_nome, Midia.tipo as midia_tipo,".
        "Imovel.id as imovel_id, Imovel.rua as rua, Imovel.numero as numero,".
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
        " FROM Midia INNER JOIN Imovel ON Midia.imovel = Imovel.id INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id INNER JOIN TipoTransacao ON Imovel.tipo_transacao = TipoTransacao.id INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id INNER JOIN CategoriaImovel ON SubCategoriaImovel.categoria = CategoriaImovel.id INNER JOIN Proprietario ON Imovel.proprietario = Proprietario.id".        
        " WHERE(Midia.id = '".$id."')";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        $midias_list = $this->criarVariosFromSql($results);
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
        $sql = "SELECT Midia.id as midia_id, Midia.url as midia_url, Midia.capa as midia_capa, Midia.nome as midia_nome, Midia.tipo as midia_tipo,".
        "Imovel.id as imovel_id, Imovel.rua as rua, Imovel.numero as numero,".
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
        " FROM Midia INNER JOIN Imovel ON Midia.imovel = Imovel.id INNER JOIN Bairro ON Imovel.bairro = Bairro.id INNER JOIN cidade ON Bairro.cidade = cidade.id INNER JOIN estado ON cidade.estado = estado.id INNER JOIN pais ON estado.pais = pais.id INNER JOIN TipoTransacao ON Imovel.tipo_transacao = TipoTransacao.id INNER JOIN SubCategoriaImovel ON Imovel.subCategoria = SubCategoriaImovel.id INNER JOIN CategoriaImovel ON SubCategoriaImovel.categoria = CategoriaImovel.id INNER JOIN Proprietario ON Imovel.proprietario = Proprietario.id".        
        " WHERE(Midia.imovel = '".$param."') LIMIT ".$de.", ".($qtd+1)."";
        $statement = $adapter->query($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        $midias_list = $this->criarVariosFromSql($results);
        return $midias_list;
    }
    
    public function recuperarTotal($id){//recupera a quatidade total de midias cadastradas para um determinado imovel
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Midia WHERE(imovel= '".$id."')";
        $statement = $adapter->query($sql);
        $result = $statement->execute();
        $this->fecharConexao();
        $total = count($this->criarVarios($result));
        return $total;
    }
    
    
    public function existeCapa($imovel){//verifica se existe alguma capa para o imovel
        $adapter = $this->getAdapter();
        $sql = "SELECT * FROM Midia WHERE(imovel='".$imovel->getId()."' AND Midia.capa = '".TRUE."')";
        $statement = $adapter->query($sql);
        $result = $statement->execute();
        $total = count($this->criarVarios($result));
        if($total == 1){
            return true;
        }else{
            return false;
        }
    }

    public function remover($id) {
        $obj = $this->recuperar($id);
        $adapter =  $this->getAdapter();
        if($obj->getTipo() != TipoMidia::SEM_MIDIA){//impede que de alguma maneira o usuario delete a midia que possui a imagem default "sem_midia.png"
            unlink($_SERVER['DOCUMENT_ROOT'].$obj->getUrl());
            try{
            $sql = "DELETE FROM Midia WHERE(id =".$id.")";
            $statement = $adapter->query($sql);
            $results = $statement->execute();
            }catch(\Zend\Db\Adapter\Exception\RuntimeException $e){
               return "Não foi possível excluir, esta Midia faz referência a um imóvel";
           }
        }
       if($this->existeCapa($obj->getImovel()) != TRUE){//se o usario tiver setado uma capa e depois tiver apagado esta mesma imagem , isto irá setar a imagem default novamente como capa
           $sql = "UPDATE Midia SET capa ='".TRUE."' WHERE(imovel=".$obj->getImovel()->getId()." AND tipo= ".TipoMidia::SEM_MIDIA.")";
           $statement = $adapter->createStatement($sql);
           $results = $statement->execute();
       }
    }
    
    public function salvarCapa($id){
        $aux = $this->limparCapa();// a funçao limpar capa seta false em todos as outras fotas, e ainda retorna o true para o update do selecionar capa
        $adapter =  $this->getAdapter();
        $sql = "UPDATE Midia SET capa =".$aux." WHERE id=".$id;
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        return true;
    }
    
    public function limparCapa(){
        $adapter =  $this->getAdapter();
        $aux =false;
        $sql = "UPDATE Midia SET capa = 0";
        $statement = $adapter->createStatement($sql);
        $results = $statement->execute();
        $this->fecharConexao();
        return true;
    }

}
