<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of Proprietario
 *
 * @author thiago
 */
class Proprietario extends \Base\Entity\AbstractEntity {
    
    private $_id;
    private $_nome;
    private $_bairro;
    private $_logradouro;
    private $_numero;
    private $_telefone;
    private $_celular;// array
    private $_cpf;
    private $_rg;
    private $_profissao;
    
    public function getId() {
        return $this->_id;
    }

    public function getNome() {
        return utf8_decode($this->_nome);
    }
    

    public function getBairro() {
        return $this->_bairro;
    }

    public function getLogradouro() {
        return utf8_decode($this->_logradouro);
    }

    public function getNumero() {
        return utf8_decode($this->_numero);
    }

    public function getTelefone() {
        return utf8_decode($this->_telefone);
    }

    public function getCelular() {
        return utf8_decode($this->_celular);
    }

    public function getCpf() {
        return utf8_decode($this->_cpf);
    }

    public function getRg() {
        return utf8_decode($this->_rg);
    }

    public function getProfissao() {
        return utf8_decode($this->_profissao);
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setNome($nome) {
        $this->_nome = utf8_encode($nome);
    }
    
    public function setBairro($bairro) {
        $this->_bairro = $bairro;
    }

    public function setLogradouro($logradouro) {
        $this->_logradouro = utf8_encode($logradouro);
    }

    public function setNumero($numero) {
        $this->_numero = utf8_encode($numero);
    }

    public function setTelefone($telefone) {
        $telefone = str_replace(array("(",")","-"), "", $telefone);
        $this->_telefone = utf8_encode($telefone);
    }

    public function setCelular($celular) {
        $celular = str_replace(array("(",")","-"), "", $celular);
        $this->_celular = utf8_encode($celular);
    }

    public function setCpf($cpf) {
        $cpf = str_replace(array(".","-"),"", $cpf);
        $this->_cpf = utf8_encode($cpf);
    }

    public function setRg($rg) {
        $this->_rg = utf8_encode($rg);
    }

    public function setProfissao($profissao) {
        $this->_profissao = utf8_encode($profissao);
    }
    
    public function mascaraCpf(){
        $a= substr($this->_cpf, 0,3); 
        $b= substr($this->_cpf, 3,3); 
        $c= substr($this->_cpf,6,3); 
        $d= substr($this->_cpf,9,2); 
        $cpf_formatado = $a.'.'.$b.'.'.$c.'-'.$d; 
        return $cpf_formatado; 
    }
    public function mascaraTel(){
        $a = sbstr($this->_telefone, 0,2);
        $b = sbstr($this->_telefone, 2,4);
        $c = sbstr($this->_telefone, 6,4);
        $tel_formatado = "(".$a.")".$b."-".$c;
        return $tel_formatado;
    }
    
    public function mascaraCel(){
        $a = sbstr($this->_celular, 0,2);
        $b = sbstr($this->_celular, 2,5);
        $c = sbstr($this->_celular, 7,4);
        $cel_formatado = "(".$a.")".$b."-".$c;
        return $cel_formatado;
    }
}
