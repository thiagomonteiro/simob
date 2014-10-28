<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of Imovel
 *
 * @author thiago
 */
class Imovel extends \Base\Entity\AbstractEntity {
    private $_id;
    private $_bairro;
    private $_rua;
    private $_numero;
    private $_areaTotal;
    private $_areaConstruida;
    private $_valorIptu;
    private $_valorTransacao;
    private $_descricao;
    private $_tipoTransacao;
    private $_proprietario;
    private $_subCategoria;
    
    
    public function setId($id){
        $this->_id = $id;
    }
    
    public function getId(){
        return $this->_id;
    }
    
    public function setBairro(\Application\Entity\Bairro $bairro){
        $this->_bairro = $bairro;
    }
    
    public function getBairro(){
        return $this->_bairro;
    }
    
    public function setRua($rua){
        $this->_rua = $rua;
    }
    
    public function getRua(){
        return $this->_rua;
    }
    
    public function setNumero($numero){
        $this->_numero = $numero;
    }
    
    public function getNumero(){
       return $this->_numero; 
    }
    
    public function setAreaTotal($total){
        $this->_areaTotal = $total;
    }
    
    public function getAreaTotal(){
        return $this->_areaTotal;
    }
    
    public function setAreaConstruida($construida){
        $this->_areaConstruida = $construida;
    }
    
    public function getAreaConstruida(){
        return $this->_areaConstruida;
    }
    
    public function setValorIptu($iptu){
        $this->_valorIptu = $iptu; 
    }
    
    public function getValorIptu(){
        return $this->_valorIptu;
    }
    
    public function setValorTransacao($valor){
        $this->_valorTransacao = $valor;
    }
    
    public function getValorTransacao(){
        return $this->_valorTransacao;
    }
    
    public function setDescricao($descricao){
        $this->_descricao = $descricao;
    }
    
    public function getDescricao(){
        return $this->_descricao;
    }
    
    public function setTipoTransacao($transacao){
        $this->_tipoTransacao = $transacao;
    }
    
    public function getTipoTransacao(){
        return $this->_tipoTransacao;
    }
    
    public function setSubCategoria($subCategoria){
        $this->_subCategoria = $subCategoria;
    }
    
    public function getSubCategoria(){
        return $this->_subCategoria;
    }
    
    public function setProprietario(\Application\Entity\Proprietario $proprietario){
        $this->_proprietario = $proprietario;
    }
    
    public function getProprietario(){
        return $this->_proprietario;
    }
}