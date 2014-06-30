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
    
    public function getId() {
        return $this->_id;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getUrl() {
        return $this->_url;
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

}
