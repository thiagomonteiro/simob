<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of Midia
 *
 * @author thiago
 */
class Midia extends \Base\Entity\AbstractEntity {    
    private $_id;
    private $_tipo;//sera video ou imagem
    private $_url;
    private $_nome;
    private $_capa;
    private $_imovel;
    
    public function getId() {
        return $this->_id;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getUrl() {
        return $this->_url;
    }

    public function getNome() {
        return $this->_nome;
    }

    public function getCapa() {
        return $this->_capa;
    }
    
    public function getImovel(){
        return $this->_imovel;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setTipo($tipo) {
        $this->_tipo = $tipo;
    }

    public function setUrl($url) {
        $this->_url = $url;
    }

    public function setNome($nome) {
        $this->_nome = $nome;
    }

    public function setCapa($capa) {
        $this->_capa = $capa;
    }
    
    public function setImovel($imovel){
        $this->_imovel = $imovel;
    }
}
