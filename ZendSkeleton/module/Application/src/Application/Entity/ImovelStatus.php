<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of ImovelStatus
 *
 * @author thiago
 */
class ImovelStatus extends \Base\Entity\AbstractEntity {
    private $_id;
    private $_data;
    private $_anotacoes;
    private $_status;
    
    public function __construct() {
         $this->_status = \Application\Entity\TipoStatus::ATIVO;
    }
    
    public function getId() {
        return $this->_id;
    }

    public function getData() {
        return $this->_data;
    }

    public function getAnotacoes() {
        return $this->_anotacoes;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setData($data) {
        $this->_data = $data;
    }

    public function setAnotacoes($anotacao) {
        $this->_anotacoes = $anotacao;
    }

    public function setStatus($status) {
        $this->_status = $status;
    }


}
