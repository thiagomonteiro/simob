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
    private $_endereco;
    private $_numero;
    private $_telefone;
    private $_celular=array();// array
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
        return utf8_decode($this->_bairro);
    }

    public function getEndereco() {
        return utf8_decode($this->_endereco);
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
        $this->_bairro = utf8_encode($bairro);
    }

    public function setEndereco($endereco) {
        $this->_endereco = utf8_encode($endereco);
    }

    public function setNumero($numero) {
        $this->_numero = utf8_encode($numero);
    }

    public function setTelefone($telefone) {
        $this->_telefone = utf8_encode($telefone);
    }

    public function setCelular($celular) {
        $this->_celular = utf8_encode($celular);
    }

    public function setCpf($cpf) {
        $this->_cpf = utf8_encode($cpf);
    }

    public function setRg($rg) {
        $this->_rg = utf8_encode($rg);
    }

    public function setProfissao($profissao) {
        $this->_profissao = utf8_encode($profissao);
    }
}
